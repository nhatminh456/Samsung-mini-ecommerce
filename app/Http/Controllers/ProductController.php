<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Thêm thư viện này để tạo mã ID ngẫu nhiên

class ProductController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $bestsellers = Product::where('bestSeller', 1)->take(8)->get();
        // Lấy danh sách sản phẩm mới nhất
        $products = Product::orderBy('id', 'desc')->take(8)->get();

        return view('index', compact('categories', 'bestsellers', 'products'));
    }

    public function index(Request $request, $category_id = null)
    {
        $query = Product::query();

        // 1. Tìm kiếm theo tên
        if ($request->has('q')) {
            $query->where('tenSP', 'like', '%' . $request->q . '%');
        }

        // 2. Lọc theo danh mục từ URL parameter hoặc query string
        $catId = $category_id ?? $request->category_id;
        if ($catId) {
            $query->where('categoryID', $catId);
        }

        // Tích hợp phân trang (12 sản phẩm trên 1 trang), dán append(request->query) để cho phép tìm kiếm và pagination chạy mượt với nhau
        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        // Đổi 'category_id' thành 'categoryID'
        $related_products = Product::where('categoryID', $product->categoryID)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('product_detail', compact('product', 'related_products'));
    }

    public function adminIndex()
    {

        $products = Product::with('category')->orderByRaw('CAST(id AS UNSIGNED) asc')->get();
        return view('admin_products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin_add_product', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|numeric|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'price.min' => 'Giá sản phẩm phải lớn hơn 0',
            'stock_quantity.min' => 'Số lượng không được âm'
        ]);

        $imageUrl = $this->handleImageUpload($request);
        if ($imageUrl && is_string($imageUrl)) {
            $imageUrl = trim($imageUrl);
        }

        // Lấy ID tự tăng bằng cách tìm max integer hiện tại
        $maxId = DB::table('products')->selectRaw('MAX(CAST(id AS UNSIGNED)) as max_id')->value('max_id');
        $newId = $maxId ? $maxId + 1 : 1;

        Product::create([
            'id' => (string) $newId,
            'tenSP' => $request->name,
            'gia' => $request->price,
            'categoryID' => $request->category_id,
            'stock_quantity' => $request->stock_quantity,
            'mota' => $request->description,
            'image' => $imageUrl
        ]);

        return redirect('/admin/products')->with('success', 'Tạo sản phẩm thành công');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin_edit_product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|numeric|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $imageUrl = $request->hasFile('image_file') ? $this->handleImageUpload($request) : $request->image_url;

        // Cập nhật theo tên cột mới
        $product->update([
            'tenSP' => $request->name,
            'gia' => $request->price,
            'categoryID' => $request->category_id,
            'stock_quantity' => $request->stock_quantity,
            'mota' => $request->description,
            'image' => $imageUrl
        ]);

        return redirect('/admin/products')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect('/admin/products')->with('success', 'Xóa sản phẩm thành công');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return back()->with('danger', 'Không thể xóa sản phẩm vì đã tồn tại trong đơn hàng');
            }
            return back()->with('danger', 'Đã xảy ra lỗi khi xóa');
        }
    }

    private function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            return 'images/' . $filename;
        }

        $url = $request->image_url;
        if ($url) {
            // Xử lý link từ Google Tìm kiếm ảnh
            if (str_contains(strtolower($url), 'google.com/imgres')) {
                parse_str(parse_url($url, PHP_URL_QUERY), $params);
                if (isset($params['imgurl'])) return $params['imgurl'];
            }

            // Xử lý một số link dài khác nếu cần thiết (loại bỏ tham số query không cần thiết)
            // Tạm thời trả về nguyên mẫu URL để hiển thị, front-end sẽ tự load
            return $url;
        }

        return null;
    }
}
