<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CertifierController extends Controller
{
    public function index()
    {
        // Mostrar productos que esperan certificación ecológica
        $products = Product::where('is_active', true)
                        ->where('is_eco_certified', false)
                        ->latest()
                        ->paginate(20);

        return view('certifier.index', compact('products'));
    }

    public function certify(Product $product)
    {
        $product->update([
            'is_eco_certified' => true
        ]);

        return back()->with('success', 'El producto "' . $product->name . '" ha sido certificado ecológicamente.');
    }
}
