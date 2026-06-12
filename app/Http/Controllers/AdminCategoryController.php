<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin_categories', compact('categories'));
    }

    public function create()
    {
        return view('admin_add_category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenDM' => 'required|string|max:255'
        ], [
            'tenDM.required' => 'Vui lòng nhập tên danh mục'
        ]);

        Category::create([
            'name' => $request->tenDM
        ]);

        return redirect('/admin/categories')->with('success', 'Thêm danh mục thành công');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin_edit_category', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'tenDM' => 'required|string|max:255'
        ], [
            'tenDM.required' => 'Vui lòng nhập tên danh mục'
        ]);

        $category->update([
            'name' => $request->tenDM
        ]);

        return redirect('/admin/categories')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect('/admin/categories')->with('success', 'Xóa danh mục thành công');
        } catch (QueryException $e) {
            // Error code 23000 typically means foreign key constraint violation
            if ($e->getCode() == '23000') {
                return back()->with('danger', 'Không thể xóa do danh mục này đang chứa sản phẩm');
            }
            return back()->with('danger', 'Đã xảy ra lỗi khi xóa danh mục');
        }
    }
}
