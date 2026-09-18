<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class PaymentController extends Controller
{
    /**
     * Procesar pago según método seleccionado
     */
    public function initiate(Request $request)
    {
        // Validaciones básicas
        $rules = [
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:mercado_pago,transfer',
        ];

        $request->validate($rules);

        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        // Validar que no intente comprar sus propios productos
        foreach ($products as $product) {
            if ($product->user_id === Auth::id()) {
                return back()->with('error', "No puedes comprar tu propio producto: {$product->name}");
            }
        }

        // Validar stock
        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            if ($product->stock < $quantity) {
                return back()->with('error', "Stock insuficiente para {$product->name}");
            }
        }

        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product->price * $cart[$product->id]['quantity'];
        }

        // Crear orden y pago pendiente
        $order = DB::transaction(function () use ($products, $cart, $request, $totalAmount) {
            // Crear orden con estado pending
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
            ]);

            // Crear items de la orden
            foreach ($products as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id]['quantity'],
                    'price' => $product->price,
                ]);
            }

            return $order;
        });

        // Crear registro de pago
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => 'pending',
            'amount' => $totalAmount,
        ]);

        // Procesar según método
        if ($request->payment_method === 'mercado_pago') {
            return $this->processMercadoPago($order, $payment);
        } else {
            return $this->processTransfer($order, $payment);
        }
    }

    /**
     * Procesar pago con Mercado Pago
     */
    private function processMercadoPago(Order $order, Payment $payment)
    {
        try {
            // Configurar credenciales de Mercado Pago
            MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));

            // Preparar items para Mercado Pago
            report($e);
            return back()->with('error', 'No se pudo iniciar el pago. Inténtalo de nuevo.');
            foreach ($order->items as $item) {
                $items[] = [
                    'id' => (string) $item->id,
                    'title' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => (float) $item->price,
                ];
            }

            // Crear preferencia
            $client = new PreferenceClient();
            $preference = $client->create([
                'items' => $items,
                'payer' => [
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name,
                ],
                'back_urls' => [
                    'success' => route('payment.success'),
                    'failure' => route('payment.failure'),
                    'pending' => route('payment.failure'),
                ],
                'notification_url' => route('payment.webhook'),
                'external_reference' => (string) $order->id,
                'auto_return' => 'approved',
            ]);

            // Guardar ID de preferencia
            $payment->update([
                'mercado_pago_id' => $preference->id,
                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    ['preference_url' => $preference->init_point]
                ),
            ]);

            // Redirigir a Mercado Pago
            return redirect($preference->init_point);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar con Mercado Pago: ' . $e->getMessage());
        }
    }

    /**
     * Procesar transferencia bancaria manual
     */
    private function processTransfer(Order $order, Payment $payment)
    {
        // Guardar datos de transferencia
        $payment->update([
            'status' => 'pending',
            'metadata' => [
                'bank_account' => config('services.bank.account'),
                'bank_name' => config('services.bank.name'),
                'bank_code' => config('services.bank.code'),
                'reference' => 'ECO-' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
            ],
        ]);

        // Limpiar sesión del carrito
        session()->forget('cart');

        return redirect()->route('payment.transfer', $order->id);
    }

    /**
     * Página de éxito de Mercado Pago
     */
    public function success(Request $request)
    {
        // Buscar orden por external_reference
        if ($request->has('external_reference')) {
            $order = Order::whereKey($request->external_reference)
                ->where('user_id', Auth::id())
                ->first();
            if ($order) {
                return view('orders.payment_success', compact('order'));
            }
        }

        return redirect()->route('products.index')->with('error', 'Orden no encontrada');
    }

    /**
     * Página de fallo de Mercado Pago
     */
    public function failure(Request $request)
    {
        if ($request->has('external_reference')) {
            $order = Order::whereKey($request->external_reference)
                ->where('user_id', Auth::id())
                ->first();
            if ($order) {
                $payment = $order->payment;
                $payment->markAsFailed('Usuario canceló en Mercado Pago');

                return view('orders.payment_failure', compact('order'));
            }
        }

        return redirect()->route('products.index')->with('error', 'Error en el pago');
    }

    /**
     * Página de transferencia pendiente
     */
    public function transfer(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $payment = $order->payment;

        return view('orders.payment_transfer', compact('order', 'payment'));
    }

    /**
     * Webhook de Mercado Pago
     */
    public function webhook(Request $request)
    {
        $dataId = (string) data_get($request->all(), 'data.id', $request->query('id'));
        if ($request->input('type') !== 'payment' || $dataId === '') {
            return response()->json(['success' => true]);
        }

        $signature = $request->header('x-signature');
        $requestId = $request->header('x-request-id');
        $secret = config('services.mercado_pago.webhook_secret');
        if (!$secret || !$this->hasValidWebhookSignature($signature, $requestId, $dataId, $secret)) {
            return response()->json(['message' => 'Invalid webhook signature'], 401);
        }

        $response = Http::withToken(config('services.mercado_pago.access_token'))
            ->get('https://api.mercadopago.com/v1/payments/' . urlencode($dataId));
        if (!$response->successful()) {
            return response()->json(['message' => 'Unable to verify payment'], 502);
        }

        $paymentData = $response->json();
        $order = Order::whereKey(data_get($paymentData, 'external_reference'))->first();
        if (!$order || !$order->payment || (float) $order->total_amount !== (float) data_get($paymentData, 'transaction_amount')) {
            return response()->json(['message' => 'Invalid payment reference'], 422);
        }

        if (data_get($paymentData, 'status') === 'approved') {
            $this->completeOrder($order, $order->payment, $dataId);
        } elseif (in_array(data_get($paymentData, 'status'), ['rejected', 'cancelled'], true)) {
            $order->payment->markAsFailed('Pago rechazado por Mercado Pago');
        }

        return response()->json(['success' => true]);
    }

    private function hasValidWebhookSignature(?string $signature, ?string $requestId, string $dataId, string $secret): bool
    {
        if (!$signature || !$requestId || !str_contains($signature, 'ts=') || !str_contains($signature, 'v1=')) {
            return false;
        }

        preg_match('/(?:^|,)ts=([^,]+)/', $signature, $timestamp);
        preg_match('/(?:^|,)v1=([^,]+)/', $signature, $hash);
        if (empty($timestamp[1]) || empty($hash[1]) || !ctype_digit($timestamp[1])) {
            return false;
        }

        if (abs(now()->timestamp - (int) $timestamp[1]) > 300) {
            return false;
        }

        $manifest = 'id:' . $dataId . ';request-id:' . $requestId . ';ts:' . $timestamp[1] . ';';
        return hash_equals($hash[1], hash_hmac('sha256', $manifest, $secret));
    }

    /**
     * Completar orden después del pago exitoso
     */
    private function completeOrder(Order $order, Payment $payment, $transactionId)
    {
        DB::transaction(function () use ($order, $payment, $transactionId) {
            $payment->refresh();
            if ($payment->isPaid()) {
                return;
            }

            $items = $order->items()->lockForUpdate()->get();
            foreach ($items as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->firstOrFail();
                if ($product->stock < $item->quantity) {
                    throw new \RuntimeException("Stock insuficiente para el producto {$product->name}");
                }
            }

            // Marcar pago como completado
            $payment->markAsPaid($transactionId);

            // Actualizar estado de orden
            $order->update(['status' => 'paid']);

            // Decrementar stock
            foreach ($items as $item) {
                Product::whereKey($item->product_id)->decrement('stock', $item->quantity);
            }

            // Enviar email de confirmación
            // Mail::send(new OrderConfirmed($order));
        });
    }

    /**
     * Marcar transferencia como pagada (admin verifica)
     */
    public function markTransferAsPaid(Order $order)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $payment = $order->payment;
        
        DB::transaction(function () use ($order, $payment) {
            $this->completeOrder($order, $payment, 'TRANSFER-' . now()->timestamp);
        });

        return redirect()->route('admin.orders.all')->with('success', 'Pago verificado y orden procesada');
    }
}
