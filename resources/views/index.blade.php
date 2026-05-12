@extends('base')

@section('title', 'Trang chủ - SAMSUNG Center')

@section('content')
<div class="hero-section text-white position-relative" style="min-height: 85vh; display: flex; align-items: center; overflow: hidden;">
    <video autoplay muted loop playsinline class="position-absolute w-100 h-100" style="object-fit: cover; z-index: 0;">
        <source src="{{ asset('videos/Video.mp4') }}" type="video/mp4">
    </video>
    
    <div class="position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.3)); z-index: 1;"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto text-center">
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Danh mục sản phẩm</h2>

    @php
    $categoryImages = [
        'S-Series' => 'images/categories/S24u.jpg',
        'A-Series' => 'images/categories/samsuma35.jpg',
        'M-Series' => 'images/categories/samsumm35.jpg',
        'Z-Series' => 'images/categories/zfold7.jpg',
        'Phụ kiện' => 'images/categories/opcasetify.jpg',
        'Gia Dụng' => 'images/categories/tulanh.jpg',
        'Màn Hình' => 'images/categories/manhinh.jpg',
        'Đồng hồ' => 'images/categories/dongho.jpg'
    ];
    @endphp

    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-3 mb-3">
            <a href="{{ url('/category/' . $category->id) }}" class="text-decoration-none">
                <div class="card category-card text-center h-100">
                    @isset($categoryImages[$category->name])
                        <img src="{{ asset($categoryImages[$category->name]) }}"
                             alt="{{ $category->name }}"
                             style="height: 160px; object-fit: contain; background: #f8f9fa; padding: 8px; border-radius: 8px 8px 0 0;"
                             onerror="this.style.display='none'">
                    @else
                        <div class="pt-4">
                            <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                        </div>
                    @endisset
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted">Xem sản phẩm</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@if(isset($bestsellers) && count($bestsellers) > 0)
<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">
            <i class="fas fa-fire text-danger"></i> Sản phẩm bán chạy
        </h2>
        <div class="row">
            @foreach ($bestsellers as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Best Seller</span>
                    <img src="{{ asset($product->image_url) }}" 
                         class="card-img-top" alt="{{ $product->name }}"
                         onerror="this.src='https://placehold.co/300x200?text={{ urlencode($product->name) }}'">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <a href="{{ url('/product/' . $product->id) }}" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="container my-5">
    <h2 class="text-center mb-4">Sản phẩm mới nhất</h2>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card product-card h-100">
                 <img src="{{ asset($product->image_url) }}" 
                     class="card-img-top" alt="{{ $product->name }}"
                     onerror="this.src='https://placehold.co/300x200?text={{ urlencode($product->name) }}'">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                    <a href="{{ url('/product/' . $product->id) }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ url('/products') }}" class="btn btn-primary btn-lg">
            Xem tất cả sản phẩm <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                <h5>Miễn phí vận chuyển</h5>
                <p class="text-muted">Cho đơn hàng trên 5 triệu</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>Bảo hành chính hãng</h5>
                <p class="text-muted">12 tháng 1 đổi 1</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                <h5>Hỗ trợ 24/7</h5>
                <p class="text-muted">Tư vấn nhiệt tình</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
                <h5>Thanh toán đa dạng</h5>
                <p class="text-muted">COD, Chuyển khoản, Thẻ</p>
            </div>
        </div>
    </div>
</div>
@endsection