<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // ========================================================
    // 1. PHẦN DÀNH CHO KHÁCH HÀNG (MUA HÀNG VÀ THANH TOÁN)
    // ========================================================

    public function showCheckout()
    {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/orders')->with('warning', 'Tài khoản admin không thể mua hàng, chỉ được quản lý.');
        }

        $cartSession = Session::get('cart', []);
        if (empty($cartSession)) {
            return redirect('/products')->with('warning', 'Giỏ hàng trống!');
        }

        $cart = [];
        $total = 0;

        foreach ($cartSession as $variantId => $details) {
            $details['subtotal'] = $details['price'] * $details['quantity'];
            $total += $details['subtotal'];
            $cart[] = (object) $details;
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        if (Auth::user()->role === 'admin') return redirect('/admin/orders');

        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect('/products');

        $request->validate([
            'name'           => 'required',
            'phone'          => 'required',
            'address'        => 'required',
            'payment_method' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $total   = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $orderId = 'ORD' . date('YmdHis') . strtoupper(Str::random(4));

            $order = Order::create([
                'id'               => $orderId,
                'user_id'          => Auth::id(),
                'user_email'       => Auth::user()->email,
                'order_date'       => now(),
                'total_amount'     => $total,
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $request->name,
                'shipping_phone'   => $request->phone,
                'shipping_address' => $request->address,
                'payment_method'   => $request->payment_method,
                'notes'            => $request->notes,
            ]);

            foreach ($cart as $variantId => $item) {
                // Khóa dòng dữ liệu lại để tránh lỗi người khác mua cùng lúc (Race condition)
                $variant = ProductVariant::with('product')->lockForUpdate()->findOrFail($variantId);

                if ($variant->stock_quantity < $item['quantity']) {
                    throw new \Exception("Phiên bản {$variant->color} - {$variant->storage} chỉ còn {$variant->stock_quantity} chiếc.");
                }

                // Ghép tên phân loại vào tên sản phẩm để lưu xuống DB
                $productNameFull = $item['name'] . ' (' . $item['color'] . ' - ' . $item['storage'] . ')';

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'variant_id'    => $item['id'], // Chèn thêm mã Variant ID để sau này refun kho đúng loại
                    'product_name'  => $productNameFull,
                    'product_price' => $item['price'],
                    'quantity'      => $item['quantity'],
                    'subtotal'      => $item['price'] * $item['quantity']
                ]);

                // Trừ tồn kho trong bảng Variants
                $variant->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            Session::forget('cart');

            if ($request->payment_method === 'bank_transfer') {
                return redirect("/orders/{$order->id}")->with('success', 'Đặt hàng thành công! Vui lòng quét QR để thanh toán.');
            }

            if ($request->payment_method === 'e_wallet') {
                // Hiện tại dự án chưa định tuyến VNPay, tạm thời chuyển về chi tiết đơn báo chờ thanh toán.
                return redirect("/orders/{$order->id}")->with('warning', 'Hệ thống thanh toán ví điện tử đang bảo trì, vui lòng thanh toán quét mã QR thủ công sau!');
            }

            return redirect("/orders/{$order->id}")->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function userOrders()
    {
        if (Auth::user()->role === 'admin') return redirect('/admin/orders');

        $orders = Order::where('user_id', Auth::id())->orderBy('order_date', 'desc')->get();
        return view('order_history', compact('orders'));
    }

    public function orderDetail(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('order_detail', compact('order'));
    }

    public function cancelOrder(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) abort(403);

        if ($order->status !== 'pending') {
            return back()->with('danger', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            // Refund kho cho Variant tương ứng đã mua
            foreach ($order->items as $item) {
                if ($item->variant) {
                    $item->variant->increment('stock_quantity', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Hủy đơn hàng thành công, đã hoàn trả số lượng vào kho.');
    }

    // ========================================================
    // 2. PHẦN DÀNH CHO ADMIN (QUẢN TRỊ ĐƠN HÀNG)
    // ========================================================

    public function confirmPayment(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return back()->with('warning', 'Đơn hàng này đã được xác nhận thanh toán rồi!');
        }

        $order->update(['payment_status' => 'paid']);

        return back()->with('success', '✅ Đã xác nhận thanh toán thành công!');
    }

    public function adminOrders()
    {
        $orders = Order::with('user')->orderBy('order_date', 'desc')->get();
        return view('admin_orders', compact('orders'));
    }

    public function adminOrderDetail(string $id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin_order_detail', compact('order'));
    }

    public function adminUpdateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function adminConfirmPayment(string $id)
    {
        $order = Order::findOrFail($id);

        $updateData = ['payment_status' => 'paid'];
        // Tự động chuyển trạng thái đơn hàng sang Đang xử lý nếu đang ở Chờ xử lý
        if ($order->status === 'pending') {
            $updateData['status'] = 'processing';
        }

        $order->update($updateData);

        return back()->with('success', 'Đã xác nhận thanh toán thành công!');
    }

    public function adminDestroy(string $id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order) {
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->variant) {
                        $item->variant->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            $order->items()->delete();
            $order->delete();
        });

        return redirect('/admin/orders')->with('success', 'Đã xóa đơn hàng thành công!');
    }
}
