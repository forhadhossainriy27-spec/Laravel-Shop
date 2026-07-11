<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 1)->count();

        $inactiveProducts = Product::where('status', 0)->count();

        $featuredProducts = Product::where('featured', 1)->count();

        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        $totalInventoryValue = Product::sum(
            DB::raw('price * stock')
        );

        $recentProducts = Product::whereDate(
            'created_at',
            '>=',
            now()->subDays(30)
        )->count();

        $categoryChart = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'featuredProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalInventoryValue',
            'recentProducts',
            'categoryChart'
        ));
    }
}
