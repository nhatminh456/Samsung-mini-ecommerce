<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem đã đăng nhập chưa VÀ có phải là admin không
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Hợp lệ -> Cho phép đi tiếp vào Controller
            return $next($request);
        }

        // Không hợp lệ -> Đá về trang chủ kèm thông báo lỗi
        return redirect('/')->with('danger', 'Bạn không có quyền truy cập khu vực quản trị!');
    }
}