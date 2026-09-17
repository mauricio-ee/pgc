<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Guardar una reseña.
     */
    public function store(Request $request, Product $product)
    {
        $hasPurchased = Order::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['review' => 'Solo puedes reseñar productos que hayas comprado.']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Evitar múltiples reseñas por producto desde el controlador aunque esté en DB
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            return back()->withErrors(['review' => 'Ya has calificado este producto anteriormente.']);
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '¡Gracias por dejar tu reseña ecológica!');
    }
}
