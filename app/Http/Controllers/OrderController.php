<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Thêm thư viện tạo chuỗi ngẫu nhiên

class OrderController extends Controller
{
    public function showCheckout()
    {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/orders')->with('warning', 'Tài khoản admin không thể mua hàng, chỉ được quản lý.');
        }

        $cartSession = session()->get('cart', []);
        if (empty($cartSession)) {
            return redirect('/products')->with('warning', 'Giỏ hàng trống!');
        }

        $cart = [];
        $total = 0;

        // Tính tổng tiền và ép kiểu array sang object để View Blade dùng được cú pháp tương tự giỏ hàng
        foreach ($cartSession as $id => $details) {
            $details['subtotal'] = $details['price'] * $details['quantity'];
            $total += $details['subtotal'];
            $cart[] = (object) $details;
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/orders');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/products');

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // 1. Tạo ID đơn hàng dạng chuỗi (VD: ORD20260510ABCD)
            $orderId = 'ORD' . date('YmdHis') . strtoupper(Str::random(4));

            // 2. Tạo đơn hàng (Đã thêm order_date và user_email cho khớp DB)
            $order = Order::create([
                'id' => $orderId,
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'order_date' => now(),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_name' => $request->name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            // 3. Thêm Chi tiết đơn hàng và Trừ Tồn Kho
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);

                // Sửa thành stock_quantity
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$product->tenSP} chỉ còn {$product->stock_quantity} chiếc.");
                }

                // Sửa tên cột cho khớp bảng order_items
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Sửa cột trừ kho
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect("/orders/{$order->id}")->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function userOrders()
    {
        if (Auth::user()->role === 'admin') return redirect('/admin/orders');

        // Thay latest() bằng orderBy theo order_date
        $orders = Order::where('user_id', Auth::id())->orderBy('order_date', 'desc')->get();
        return view('order_history', compact('orders'));
    }

    // ĐỔI THÀNH string $id
    public function orderDetail(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('order_detail', compact('order'));
    }

    // ĐỔI THÀNH string $id
    public function cancelOrder(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) abort(403);

        if ($order->status !== 'pending') {
            return back()->with('danger', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            foreach ($order->items as $item) {
                // Sửa cột hoàn kho
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Hủy đơn hàng thành công, đã hoàn trả số lượng vào kho.');
    }

    public function adminOrders()
    {
        // Thay latest() bằng orderBy theo order_date
        $orders = Order::with('user')->orderBy('order_date', 'desc')->get();
        return view('admin_orders', compact('orders'));
    }

    // ĐỔI THÀNH string $id
    public function adminOrderDetail(string $id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin_order_detail', compact('order'));
    }

    // ĐỔI THÀNH string $id
    public function adminUpdateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function adminDestroy(string $id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order) {
            // Hoàn lại kho nếu đơn hàng chưa bị hủy trước đó
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            // Xóa chi tiết đơn hàng trước
            $order->items()->delete();

            // Xóa đơn hàng
            $order->delete();
        });

        return redirect('/admin/orders')->with('success', 'Đã xóa đơn hàng thành công!');
    }
}
