<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with(['product.category', 'product.user'])
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(int $product): RedirectResponse
    {
        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product,
        ]);

        return back()->with('success', 'Producto guardado en favoritos.');
    }

    public function destroy(int $product): RedirectResponse
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product)
            ->delete();

        return back()->with('success', 'Producto eliminado de favoritos.');
    }
}
