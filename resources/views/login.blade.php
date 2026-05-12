@extends('base')

@section('title', 'Đăng nhập - SAMSUNG Center')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 text-primary">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập hoặc Email:</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required placeholder="Ví dụ: cohue@gmail.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <p class="text-center mb-0">
                        Chưa có tài khoản? 
                        <a href="{{ url('/register') }}">Đăng ký ngay</a>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection