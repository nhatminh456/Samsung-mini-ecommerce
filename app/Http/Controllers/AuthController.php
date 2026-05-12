<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Thêm thư viện này để tạo ID chuỗi

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $loginInput = $request->username; // Form gửi lên biến name="username"
        $password = $request->password;

        // Tìm user theo email hoặc id
        $user = User::where('email', $loginInput)
            ->orWhere('id', $loginInput)
            ->first();

        // Kiểm tra mật khẩu
        if ($user && ($user->password === $password || Hash::check($password, $user->password))) {
            Auth::login($user);
            $request->session()->regenerate();

            // Lưu thông tin vào session thủ công để tương thích với base.blade.php cũ
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_email', $user->email);
            $request->session()->put('user_role', $user->role);
            $request->session()->put('username', $user->email);

            // Phân quyền chuyển hướng
            if ($user->role === 'admin') {
                return redirect('/admin/products')->with('success', 'Đăng nhập trang quản trị thành công!');
            }

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('danger', 'Tài khoản hoặc mật khẩu không chính xác.')->onlyInput('username');
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Bỏ validate username vì Database không có cột này
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Email này đã được đăng ký.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Tạo User mới (Tự sinh ID dạng USR1715420000ABC)
        User::create([
            'id' => 'USR' . time() . strtoupper(Str::random(3)),
            'email' => $request->email,
            'password' => Hash::make($request->password), // Băm mật khẩu bằng Bcrypt
            'role' => 'user' // Mặc định ai đăng ký cũng là khách hàng
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget(['user_id', 'user_email', 'user_role', 'username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất thành công.');
    }
}
