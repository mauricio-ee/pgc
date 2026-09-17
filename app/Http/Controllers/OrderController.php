<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;

class OrderController extends Controller
{
    /**
     * Cliente: Ver historial de pedidos
     */
    public function index()
    {
        // Evitamos N+1 cargando los items y el producto de cada item
        $orders = Order::where('user_id', Auth::id())
                    ->with('items.product')
                    ->latest()
                    ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Cliente: Mostrar la vista de Checkout con formulario de dirección y pago
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id]['quantity'];
        }

        return view('orders.checkout', compact('products', 'cart', 'total'));
    }

    /**
     * Cliente: Procesar una compra directa desde el Carrito de Compras (Checkout)
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:mercado_pago,transfer'
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

       // Obtenemos los productos para verificar stock antes de iniciar la transacción
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        // Validar que no intente comprar sus propios productos
        foreach ($products as $product) {
            if ($product->user_id === Auth::id()) {
                return back()->with('error', "No puedes comprar tu propio producto: {$product->name}. Quítalo del carrito.");
            }
        }

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            if ($product->stock < $quantity) {
                return back()->with('error', "Stock insuficiente para el producto: {$product->name}. Solo hay {$product->stock} unidades disponibles.");
            }
        }

        // Transacción para asegurar la consistencia del pedido y los ítems
        $createdOrder = DB::transaction(function () use ($products, $cart, $request) {
            $totalAmount = 0;

            foreach ($products as $product) {
                $totalAmount += $product->price * $cart[$product->id]['quantity'];
            }

            // Creamos el Pedido Global
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'paid', // Simulado pago exitoso
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];

                // Añadimos cada ítem individual al pedido
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price, // Precio fijado a futuro por inmutabilidad
                ]);

                // Descontamos el stock
                $product->decrement('stock', $quantity);
            }

            // Regresamos la orden creada de la transacción para enviar el correo si es necesario
            return $order;
        });

        // Enviar notificación al correo del usuario.
        // Asegúrate de tener MAIL_MAILER=log (o smtp configurado) en tu .env si fallara
        try {
            Mail::to(Auth::user()->email)->send(new OrderConfirmed($createdOrder));
        } catch (\Exception $e) {
            // Opcional: Logueamos el error de correo y permitimos que la compra termine bien.
            \Log::error("No se pudo enviar el correo de la orden: " . $e->getMessage());
        }

        // Limpiar el carrito después de la compra exitosa
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', '¡Compra ecológica realizada con éxito. Mírala en tu historial de pedidos!');
    }

    /**
     * Admin: Ver absolutamente todos los pedidos del sistema
     */
    public function adminIndex()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(20);
        return view('orders.admin', compact('orders')); // (Vista que puede escalarse luego)
    }
}
