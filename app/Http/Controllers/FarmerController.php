<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class FarmerController extends Controller
{
    public function show(User $user): View
    {
        abort_unless($user->isSeller(), 404);

        $products = $user->products()
            ->with('category')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('farmers.show', compact('user', 'products'));
    }
}
