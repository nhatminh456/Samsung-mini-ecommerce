<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SAMSUM Center')</title>
    <meta name="author" content="Trần Nhật Minh - MSSV: 23140006">
    <meta name="copyright" content="Dự án cá nhân năm 2026">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    
    @stack('extra_css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="{{ url('/') }}">
                <i class="fas fa-mobile-alt"></i> SAMSUNG Center
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="{{ url('/') }}">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="{{ url('/products') }}">
                            <i class="fas fa-mobile"></i> Sản phẩm
                        </a>
                    </li>
                    @php $isAdmin = (Auth::check() && Auth::user()->role === 'admin') || session('user_role') === 'admin'; @endphp
                    @if ($isAdmin)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i> Quản lý
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/products') }}">
                                <i class="fas fa-box"></i> Sản phẩm
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/orders') }}">
                                <i class="fas fa-shopping-cart"></i> Đơn hàng
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/categories') }}">
                                <i class="fas fa-tags"></i> Danh mục
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/users') }}">
                                <i class="fas fa-users"></i> Tài khoản
                            </a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
                
                <form class="d-flex me-3" action="{{ url('/search') }}" method="get">
                    <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                @php $isAdmin = (Auth::check() && Auth::user()->role === 'admin') || session('user_role') === 'admin'; @endphp
                @if (!$isAdmin)
                <a href="{{ url('/cart') }}" class="btn btn-outline-primary me-3 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-badge" style="display: {{ count(session('cart', [])) > 0 ? 'inline-block' : 'none' }};">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
                @endif
                
                <ul class="navbar-nav">
                    @php 
                        $isLoggedIn = Auth::check() || session()->has('user_id'); 
                        $isAdmin = (Auth::check() && Auth::user()->role === 'admin') || session('user_role') === 'admin';
                    @endphp
                    @if ($isLoggedIn)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::check() ? (Auth::user()->username ?? Auth::user()->email) : (session('username') ?? session('user_email')) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if ($isAdmin)
                            <li><a class="dropdown-item" href="{{ url('/admin/orders') }}">
                                <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                            </a></li>
                            @else
                            <li><a class="dropdown-item" href="{{ url('/orders') }}">
                                <i class="fas fa-history"></i> Đơn hàng của tôi
                            </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="{{ url('/register') }}">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-3">
        @foreach (['success', 'danger', 'warning', 'info'] as $msg)
            @if(session()->has($msg))
                <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
                    {{ session()->get($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach
    </div>
    
    <main>
        @yield('content')
    </main>
    
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-mobile-alt"></i> SAMSUNG Center</h5>
                    <p>Cửa hàng điện thoại Samsung uy tín #1</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>
                        <i class="fas fa-phone"></i> 0902578541<br>
                        <i class="fas fa-envelope"></i> tranminh29012005@gmail.com 
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Danh mục</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/category/1') }}" class="text-white">S-Series</a></li>
                        <li><a href="{{ url('/category/2') }}" class="text-white">A-Series</a></li>
                        <li><a href="{{ url('/category/3') }}" class="text-white">M-Series</a></li>
                        <li><a href="{{ url('/category/4') }}" class="text-white">Z-Series</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} SAMSUNG Center. Built with Laravel & PHP.</p>
            </div>
        </div>
    </footer>
    
    <div class="chatbot-container">
        <button class="chatbot-button" id="chatbot-btn">
            <i class="fas fa-comments"></i>
        </button>
        
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">
                <h4><i class="fas fa-robot"></i> Trợ lý ảo</h4>
                <button class="chatbot-close" id="chatbot-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="chatbot-messages" id="chatbot-messages">
                </div>
            
            <div class="chatbot-input">
                <input type="text" id="chatbot-input" placeholder="Nhập câu hỏi của bạn...">
                <button id="chatbot-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="{{ asset('js/ajax-cart.js') }}"></script>
    
    @stack('extra_js')
</body>
</html>