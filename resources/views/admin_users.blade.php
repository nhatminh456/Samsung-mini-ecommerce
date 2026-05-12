@extends('base')

@section('title', 'Quản lý Người dùng - Admin')

@section('content')
<style>
    .admin-header {
        background: linear-gradient(135deg, rgba(85, 239, 196, 0.95) 0%, rgba(0, 184, 148, 0.9) 100%),
                    url('{{ asset("images/samsumbanner.jpg") }}') center/cover no-repeat;
        padding: 2.5rem 0;
        margin-bottom: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 184, 148, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .admin-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('data:image/svg+xml,...') center/cover;
        opacity: 0.1;
    }

    .header-content {
        position: relative;
        z-index: 1;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
</style>

<div class="container my-4">
    <!-- Admin Header -->
    <div class="admin-header text-center text-white">
        <div class="header-content">
            <h2 class="display-5 fw-bold mb-3"><i class="fas fa-users"></i> Quản lý Người dùng</h2>
            <p class="lead mb-0 opacity-75">Quản lý tài khoản và phân quyền hệ thống</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-list text-success me-2"></i>Danh sách Tài khoản</h4>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ url('/admin/user/add') }}" class="btn btn-success btn-lg rounded-pill shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Thêm người dùng mới
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Mã ID</th>
                        <th class="py-3">Email</th>
                        <th class="py-3 text-center">Phân quyền</th>
                        <th class="py-3 text-center">Khóa ngoại</th>
                        <th class="py-3 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $user->email }}</div>
                        </td>
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-crown me-1"></i> Admin</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fas fa-user me-1"></i> User</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-white">{{ $user->orders()->count() ?? 0 }} Đơn Hàng</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/admin/user/edit/' . $user->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('/admin/user/delete/' . $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($users->isEmpty())
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"><i class="fas fa-folder-open"></i></div>
                <h5 class="text-muted">Chưa có người dùng nào.</h5>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
