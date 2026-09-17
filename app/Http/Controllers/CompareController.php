<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        // Si vienen IDs por la URL (estilo Mercado Libre), los usamos.
        $idsParam = $request->input('ids');
        if ($idsParam) {
            $compareIds = explode(',', $idsParam);
            // Guardamos en sesión por si recargan la página
            session()->put('compare', $compareIds);
        } else {
            $compareIds = session()->get('compare', []);
        }

        $products = Product::whereIn('id', $compareIds)->with('category', 'user')->get();
        
        return view('compare.index', compact('products'));
    }

    public function add(Product $product)
    {
        $compareIds = session()->get('compare', []);

        if (!in_array($product->id, $compareIds)) {
            // Limitar a máximo 4 productos para comparar
            if (count($compareIds) >= 4) {
                return back()->with('error', 'Solo puedes comparar hasta 4 productos a la vez.');
            }
            $compareIds[] = $product->id;
            session()->put('compare', $compareIds);
        }

        return back()->with('success', 'Producto agregado a la lista de comparación.');
    }

    public function remove(Product $product)
    {
        $compareIds = session()->get('compare', []);
        
        $compareIds = array_diff($compareIds, [$product->id]);
        session()->put('compare', $compareIds);

        return back()->with('success', 'Producto removido de la comparación.');
    }
    
    public function clear()
    {
        session()->forget('compare');
        return back()->with('success', 'Lista de comparación limpiada.');
    }
}
