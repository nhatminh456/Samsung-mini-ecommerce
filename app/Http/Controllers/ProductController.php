<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $bestsellers = Product::with(['images', 'variants'])->where('is_bestseller', 1)->take(8)->get();
        $products = Product::with(['images', 'variants'])->orderBy('id', 'desc')->take(8)->get();

        return view('index', compact('categories', 'bestsellers', 'products'));
    }

    public function index(Request $request, $category_id = null)
    {
        $query = Product::with(['images', 'variants']);

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $catId = $category_id ?? $request->category_id;
        if ($catId) {
            $query->where('category_id', $catId);
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'variants.images'])->findOrFail($id);

        $related_products = Product::with(['images', 'variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('product_detail', compact('product', 'related_products'));
    }

    public function adminIndex()
    {
        $products = Product::with(['category', 'variants'])->orderBy('id', 'desc')->get();
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
            'name'             => 'required',
            'category_id'      => 'required|exists:categories,id',
            'variants.0.price' => 'required|numeric|min:1',
        ], [
            'variants.0.price.required' => 'Giá phiên bản đầu tiên là bắt buộc',
            'variants.0.price.min'      => 'Giá phải lớn hơn 0',
        ]);

        DB::beginTransaction();

        try {
            // 1. Lưu sản phẩm chính
            $product = Product::create([
                'name'          => $request->name,
                'category_id'   => $request->category_id,
                'description'   => $request->description,
                'is_bestseller' => $request->has('bestSeller') ? 1 : 0,
            ]);

            // 2. Lưu từng variant + ảnh
            foreach ($request->variants as $index => $variantData) {
                if (empty($variantData['price'])) continue;

                $variant = ProductVariant::create([
                    'product_id'     => $product->id,
                    'color'          => $variantData['color'] ?? 'Mặc định',
                    'storage'        => $variantData['storage'] ?? 'Mặc định',
                    'price'          => $variantData['price'],
                    'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                    'sku'            => 'SS-' . time() . rand(10, 99),
                ]);

                // 3a. Ảnh upload từ máy
                if ($request->hasFile("variant_images.$index")) {
                    foreach ($request->file("variant_images.$index") as $file) {
                        $filename = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();
                        $file->move(public_path('images'), $filename);

                        ProductImage::create([
                            'product_id' => $product->id,
                            'variant_id' => $variant->id,
                            'image_path' => 'images/' . $filename,
                        ]);
                    }
                }

                // 3b. Ảnh nhập từ URL
                $urls = $request->input("variant_image_urls.$index", []);
                foreach ($urls as $url) {
                    $url = $this->cleanImageUrl(trim($url));
                    if (empty($url)) continue;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'image_path' => $url,   // lưu thẳng URL vào image_path
                    ]);
                }
            }

            DB::commit();
            return redirect('/admin/products')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('danger', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['variants.images', 'images'])->findOrFail($id);
        $categories = Category::all();
        return view('admin_edit_product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        DB::beginTransaction();

        try {
            // 1. Cập nhật thông tin chính
            $product->update([
                'name'          => $request->name,
                'category_id'   => $request->category_id,
                'description'   => $request->description,
                'is_bestseller' => $request->has('bestSeller') ? 1 : 0,
            ]);

            // 2. Cập nhật từng variant cũ đã có (nếu có)
            if ($request->has('variants')) {
                foreach ($request->variants as $variantId => $variantData) {
                    $variant = ProductVariant::find($variantId);
                    if (!$variant || $variant->product_id != $product->id) continue;

                    $variant->update([
                        'color'          => $variantData['color'] ?? $variant->color,
                        'storage'        => $variantData['storage'] ?? $variant->storage,
                        'price'          => $variantData['price'] ?? $variant->price,
                        'stock_quantity' => $variantData['stock_quantity'] ?? $variant->stock_quantity,
                    ]);

                    // 3a. Ảnh upload từ máy cho variant cũ
                    if ($request->hasFile("variant_images.$variantId")) {
                        foreach ($request->file("variant_images.$variantId") as $file) {
                            $filename = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();
                            $file->move(public_path('images'), $filename);

                            ProductImage::create([
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'image_path' => 'images/' . $filename,
                            ]);
                        }
                    }

                    // 3b. Ảnh nhập từ URL cho variant cũ
                    $urls = $request->input("variant_image_urls.$variantId", []);
                    foreach ($urls as $url) {
                        $url = $this->cleanImageUrl(trim($url));
                        if (empty($url)) continue;

                        ProductImage::create([
                            'product_id' => $product->id,
                            'variant_id' => $variant->id,
                            'image_path' => $url,
                        ]);
                    }
                }
            }

            // 4. Thêm các variant mới (nếu Admin có nhấn thêm ở màn hình sửa)
            if ($request->has('new_variants')) {
                foreach ($request->new_variants as $index => $variantData) {
                    if (empty($variantData['price'])) continue;

                    $variant = ProductVariant::create([
                        'product_id'     => $product->id,
                        'color'          => $variantData['color'] ?? 'Mặc định',
                        'storage'        => $variantData['storage'] ?? 'Mặc định',
                        'price'          => $variantData['price'],
                        'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                        'sku'            => 'SS-' . time() . rand(10, 99),
                    ]);

                    // 5a. Ảnh upload từ máy cho variant mới
                    if ($request->hasFile("new_variant_images.$index")) {
                        foreach ($request->file("new_variant_images.$index") as $file) {
                            $filename = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();
                            $file->move(public_path('images'), $filename);

                            ProductImage::create([
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'image_path' => 'images/' . $filename,
                            ]);
                        }
                    }

                    // 5b. Ảnh nhập từ URL cho variant mới
                    $urls = $request->input("new_variant_image_urls.$index", []);
                    foreach ($urls as $url) {
                        $url = $this->cleanImageUrl(trim($url));
                        if (empty($url)) continue;

                        ProductImage::create([
                            'product_id' => $product->id,
                            'variant_id' => $variant->id,
                            'image_path' => $url,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect('/admin/products')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('danger', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect('/admin/products')->with('success', 'Xóa sản phẩm thành công');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return back()->with('danger', 'Không thể xóa vì đã tồn tại trong đơn hàng');
            }
            return back()->with('danger', 'Đã xảy ra lỗi khi xóa');
        }
    }

    private function cleanImageUrl($url)
    {
        if (str_contains(strtolower($url), 'google.com/imgres')) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['imgurl'])) return $params['imgurl'];
        }
        return $url;
    }
}
