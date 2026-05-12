<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\CheckAdmin;

Route::post('/api/chatbot/reply', [ChatbotController::class, 'reply']);

Route::get('/', [ProductController::class, 'home']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'index']);
Route::get('/category/{category_id}', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Xác thực (Auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Giỏ hàng (Session)
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::put('/cart/update/{id}', [CartController::class, 'update']);
Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
Route::delete('/cart/clear', [CartController::class, 'clear']);



Route::middleware('auth')->group(function () {
    // Đặt hàng
    Route::get('/checkout', [OrderController::class, 'showCheckout']);
    Route::post('/checkout', [OrderController::class, 'processCheckout']);

    // Quản lý đơn hàng cá nhân
    Route::get('/orders', [OrderController::class, 'userOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'orderDetail']);
    Route::post('/orders/cancel/{id}', [OrderController::class, 'cancelOrder']);
});



Route::middleware(['auth', CheckAdmin::class])->group(function () {

    // Thống Kê / Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);

    // Quản lý Sản phẩm
    Route::get('/admin/products', [ProductController::class, 'adminIndex']);
    Route::get('/admin/product/add', [ProductController::class, 'create']);
    Route::post('/admin/product/add', [ProductController::class, 'store']);
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::put('/admin/product/edit/{id}', [ProductController::class, 'update']);
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'destroy']);
    Route::get('/developer-info', function () {
        return response()->json([
            'author' => 'Trần Nhật Minh',
            'student_id' => '23140006',
            'created_at' => 'Tháng 5/2026',
            'message' => 'Bản quyền thuộc về[Trần Nhật Minh]. Cấm sao chép dưới mọi hình thức.'
        ]);
    });

    // Quản lý Danh mục
    Route::get('/admin/categories', [AdminCategoryController::class, 'index']);
    Route::get('/admin/category/add', [AdminCategoryController::class, 'create']);
    Route::post('/admin/category/add', [AdminCategoryController::class, 'store']);
    Route::get('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit']);
    Route::put('/admin/category/edit/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/admin/category/delete/{id}', [AdminCategoryController::class, 'destroy']);

    // Quản lý Đơn hàng
    Route::get('/admin/orders', [OrderController::class, 'adminOrders']);
    Route::get('/admin/order/{id}', [OrderController::class, 'adminOrderDetail']);
    Route::post('/admin/order/update-status/{id}', [OrderController::class, 'adminUpdateStatus']);
    Route::delete('/admin/order/delete/{id}', [OrderController::class, 'adminDestroy']);

    // User CRUD
    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::get('/admin/user/add', [AdminUserController::class, 'create']);
    Route::post('/admin/user/store', [AdminUserController::class, 'store']);
    Route::get('/admin/user/edit/{id}', [AdminUserController::class, 'edit']);
    Route::put('/admin/user/update/{id}', [AdminUserController::class, 'update']);
    Route::delete('/admin/user/delete/{id}', [AdminUserController::class, 'destroy']);
});
