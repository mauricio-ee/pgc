<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'sellers' => User::where('role', 'seller')->count(),
            'products' => Product::where('is_active', true)->count(),
            'orders' => Order::count(),
            'paidOrders' => Order::where('status', 'paid')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'revenue' => Order::where('status', 'paid')->sum('total_amount'),
        ];

        $recentOrders = Order::with('user')->latest()->limit(8)->get();
        $topCategories = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.is_active', true)
            ->select('categories.name', DB::raw('COUNT(products.id) as products_count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('products_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topCategories'));
    }
}
