<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin_users', compact('users'));
    }

    public function create()
    {
        return view('admin_add_user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user'
        ]);

        User::create([
            'id' => 'USR' . time() . strtoupper(Str::random(3)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect('/admin/users')->with('success', 'Thêm người dùng thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin_edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user'
        ]);

        $data = [
            'email' => $request->email,
            'role' => $request->role
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6'
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Không cho phép xóa chính mình
        if ($user->id === auth()->user()->id) {
            return back()->with('danger', 'Bạn không được phép xóa tài khoản đang đăng nhập!');
        }
        
        // Hoặc có thể check ràng buộc khóa ngoại với đơn hàng ở đây nếu cần

        try {
            $user->delete();
            return redirect('/admin/users')->with('success', 'Xóa người dùng thành công!');
        } catch (\Exception $e) {
            return back()->with('danger', 'Không thể xóa người dùng này vì đã có dữ liệu liên quan (ví dụ: đã từng đặt hàng).');
        }
    }
}
