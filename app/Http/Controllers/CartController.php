<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Obtener los productos reales de la base de datos
        $productIds = array_keys($cart);
        $products = count($productIds) > 0 ? Product::whereIn('id', $productIds)->get() : collect();

        $total = 0;
        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $total += $product->price * $quantity;
        }

        return view('cart.index', compact('products', 'cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Validar que el usuario no sea el propietario del producto
        if (auth()->check() && $product->user_id === auth()->id()) {
            return back()->with('error', 'No puedes comprar tus propios productos. Como vendedor, gestiónalos desde tu panel.');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->quantity;

        // Verificar si supera el stock
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'No hay suficiente stock para añadir esa cantidad (Stock disponible: '.$product->stock.').');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            if ($quantity > $product->stock) {
                return back()->with('error', 'No hay suficiente stock (Stock disponible: '.$product->stock.').');
            }
            $cart[$product->id] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Producto añadido al carrito ecológico.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            if ($request->quantity > $product->stock) {
                return back()->with('error', 'No hay suficiente stock (Stock disponible: '.$product->stock.').');
            }
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cantidad actualizada en el carrito.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Producto removido del carrito.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Carrito vaciado exitosamente.');
    }
}
