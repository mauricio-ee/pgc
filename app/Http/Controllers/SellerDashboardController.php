<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        // 1. Total Vendido Histórico (Solo productos de este vendedor)
        $totalSales = OrderItem::whereHas('product', function ($q) use ($sellerId) {
            $q->where('user_id', $sellerId);
        })->sum(DB::raw('price * quantity'));

        // 2. Productos Activos
        $activeProducts = Product::where('user_id', $sellerId)->where('is_active', true)->count();

        // 3. Productos más vendidos (Top 5)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(price * quantity) as total_revenue'))
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->with('product')
            ->get();

        // 4. Últimos Pedidos Recibidos (Solo mostrando ítems del vendedor actual)
        $recentOrders = OrderItem::whereHas('product', function ($q) use ($sellerId) {
            $q->where('user_id', $sellerId);
        })
        ->with(['order', 'product', 'order.user'])
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();

        // Preparar datos para Chart.js (Ventas de los últimos 7 días)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            $dailySales = OrderItem::whereHas('product', function ($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->whereDate('created_at', $date)
            ->sum(DB::raw('price * quantity'));

            $last7Days->push([
                'date' => now()->subDays($i)->format('d M'),
                'total' => $dailySales
            ]);
        }

        $chartDates = $last7Days->pluck('date');
        $chartTotals = $last7Days->pluck('total');

        return view('seller.dashboard', compact(
            'totalSales', 'activeProducts', 'topProducts', 'recentOrders', 'chartDates', 'chartTotals'
        ));
    }
}
