<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cartSession = session()->get('cart', []);

        $cart = [];
        $total = 0;

        // Tính tổng tiền và ép kiểu array sang object để View Blade dùng được cú pháp $item->name
        foreach ($cartSession as $id => $details) {
            $details['subtotal'] = $details['price'] * $details['quantity'];
            $total += $details['subtotal'];
            $cart[] = (object) $details;
        }

        return view('cart', compact('cart', 'total'));
    }

    // 2. Thêm sản phẩm vào giỏ
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên 1
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Nếu chưa có, thêm mới vào mảng
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_url' => $product->image_url
            ];
        }

        // Lưu ngược lại vào Session
        session()->put('cart', $cart);

        // Tính tổng số lượng hàng trong giỏ
        $totalItems = count($cart);

        // Trả về JSON nếu là request từ Ajax
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm ' . $product->name . ' vào giỏ hàng!',
                'cart_count' => $totalItems
            ]);
        }

        // Trở lại trang trước đó (hoặc trang sản phẩm) kèm thông báo
        return back()->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
    }

    // 3. Cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1|max:99'
        ]);

        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Đã cập nhật số lượng thành công!');
        }

        return back()->with('danger', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    // 4. Xóa 1 sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa phần tử khỏi mảng
            session()->put('cart', $cart);
            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return back()->with('danger', 'Không tìm thấy sản phẩm.');
    }

    // 5. Xóa toàn bộ giỏ hàng
    public function clear()
    {
        // Xóa hẳn key 'cart' khỏi session
        session()->forget('cart');
        return back()->with('info', 'Đã làm trống giỏ hàng.');
    }
}
