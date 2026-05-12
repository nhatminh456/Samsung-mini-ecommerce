<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Thống kê cơ bản (không tính đơn đã hủy vào doanh thu)
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();

        // 5 đơn hàng mới nhất
        $recentOrders = Order::orderBy('order_date', 'desc')->take(5)->get();

        // Thống kê theo trạng thái đơn hàng
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pendingCount = $ordersByStatus['pending'] ?? 0;
        $processingCount = $ordersByStatus['processing'] ?? 0;
        $shippedCount = $ordersByStatus['shipped'] ?? 0;
        $deliveredCount = $ordersByStatus['delivered'] ?? 0;
        $cancelledCount = $ordersByStatus['cancelled'] ?? 0;

        return view('admin_dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'pendingCount',
            'processingCount',
            'shippedCount',
            'deliveredCount',
            'cancelledCount'
        ));
    }
}
