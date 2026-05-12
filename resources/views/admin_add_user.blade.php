@extends('base')

@section('title', 'Thêm Người dùng - Admin')

@section('content')
<style>
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
</style>

<div class="container my-5" style="max-width: 800px;">
    <div class="mb-4">
        <a href="{{ url('/admin/users') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="form-container">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark"><i class="fas fa-user-plus text-success me-2"></i>Thêm người dùng mới</h3>
            <p class="text-muted">Nhập thông tin chi tiết cho tài khoản mới</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/user/store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="example@samsung.com">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Tối thiểu 6 ký tự">
                </div>
            </div>

            <div class="mb-4">
                <label for="role" class="form-label fw-bold">Phân quyền</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-shield-alt"></i></span>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Khách hàng)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Quản trị viên)</option>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i>Tạo Tài khoản
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
