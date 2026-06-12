<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartSession = Session::get('cart', []);
        $cart = [];
        $total = 0;

        foreach ($cartSession as $variantId => $details) {
            $details['subtotal'] = $details['price'] * $details['quantity'];
            $total += $details['subtotal'];
            $cart[] = (object) $details;
        }

        return view('cart', compact('cart', 'total'));
    }

    // NÂNG CẤP: Xử lý thêm vào giỏ bằng Variant ID thay vì Product ID
    public function add(Request $request, $id = null)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'redirect' => route('login')]);
            }
            return redirect()->route('login')->with('danger', 'Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng!');
        }

        // Lấy variant_id. NẾU thêm từ danh sách (truyền ID của Product), tự động lấy Variant đầu tiên!
        if ($id) {
            $product = Product::with('variants', 'images')->findOrFail($id);
            if ($product->variants->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm này hiện ngừng kinh doanh.']);
            }
            $variant = $product->variants->first();
            $quantity = $request->quantity ?? 1;
        } else {
            // Validate nếu lấy từ form chi tiết sản phẩm
            $request->validate([
                'variant_id' => 'required|exists:product_variants,id',
                'quantity'   => 'required|numeric|min:1'
            ]);
            $variant = ProductVariant::with('product.images')->findOrFail($request->variant_id);
            $product = $variant->product;
            $quantity = $request->quantity;
        }

        // Kiểm tra tồn kho
        if ($variant->stock_quantity <= 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm đã hết hàng!']);
            }
            return back()->with('danger', 'Sản phẩm đã hết hàng!');
        }

        if ($variant->stock_quantity < $quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Rất tiếc, số lượng trong kho không đủ!']);
            }
            return back()->with('danger', 'Rất tiếc, số lượng trong kho không đủ!');
        }

        $cart = Session::get('cart', []);

        // Dùng Variant ID làm Key của giỏ hàng
        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity'] += $quantity;
        } else {
            // Lấy ảnh hiển thị: Ưu tiên ảnh riêng của Variant, không có thì lấy ảnh mặc định của Product
            $imageUrl = $product->images->first() ? $product->images->first()->image_path : 'images/default.jpg';

            $cart[$variant->id] = [
                'id'         => $variant->id,
                'product_id' => $product->id,
                'name'       => $product->name,
                'color'      => $variant->color,
                'storage'    => $variant->storage,
                'price'      => $variant->price,
                'quantity'   => $quantity,
                'image_url'  => $imageUrl
            ];
        }

        Session::put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Đã thêm ' . $product->name . ' vào giỏ hàng!',
                'cart_count' => count($cart)
            ]);
        }

        return back()->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|numeric|min:1|max:99']);
        $cart = Session::get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Đã cập nhật số lượng thành công!');
        }

        return back()->with('danger', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    public function remove($id)
    {
        $cart = Session::get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return back()->with('danger', 'Không tìm thấy sản phẩm.');
    }

    public function clear()
    {
        Session::forget('cart');
        return back()->with('info', 'Đã làm trống giỏ hàng.');
    }
}