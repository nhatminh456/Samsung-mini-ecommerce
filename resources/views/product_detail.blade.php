@extends('base')

@section('title', $product->name . ' - SAMSUNG Center')

@section('content')
<style>
    .product-detail-img {
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
    }
    
    .product-detail-img:hover {
        transform: scale(1.05);
    }
    
    .product-title-main {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 1.5rem;
    }
    
    .product-price-main {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2rem;
    }
    
    .info-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .info-card h5 {
        color: #667eea;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        font-weight: 700;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }
    
    .btn-buy-now {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        border: none;
        font-weight: 700;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(67, 233, 123, 0.4);
        transition: all 0.3s ease;
        color: white;
    }
    
    .btn-buy-now:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(67, 233, 123, 0.5);
        color: white;
    }
    
    .breadcrumb {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-6">
              <img src="{{ asset($product->image_url) }}" 
                 class="img-fluid product-detail-img" alt="{{ $product->name }}"
                 onerror="this.src='https://placehold.co/500x400?text={{ urlencode($product->name) }}'">
        </div>
        
        <div class="col-md-6">
            <h1 class="product-title-main">{{ $product->name }}</h1>
            
            @if($product->bestSeller)
            <span class="badge mb-3" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 0.6rem 1.2rem; font-size: 1rem; border-radius: 50px; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);">
                <i class="fas fa-fire"></i> Best Seller
            </span>
            @endif
            
            <h2 class="product-price-main">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h2>
            
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i> Thông tin sản phẩm</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-0"><strong>Danh mục:</strong> 
                        <span class="text-muted">{{ $product->category_name ?: 'Chưa xác định' }}</span>
                    </li>
                </ul>
            </div>
            
            @if($product->mota)
            <div class="info-card">
                <h5><i class="fas fa-align-left me-2"></i> Mô tả</h5>
                <p class="text-muted mb-0">{{ $product->mota }}</p>
            </div>
            @endif
            
            @if($product->thongso)
            <div class="info-card">
                <h5><i class="fas fa-cogs me-2"></i> Thông số kỹ thuật</h5>
                <p class="text-muted mb-0">{{ $product->thongso }}</p>
            </div>
            @endif
            
            @if(session('user_role') == 'admin')
            <div class="alert alert-warning mb-3">
                Tài khoản admin không có quyền mua sản phẩm.
            </div>
            <div class="d-grid gap-3">
                <a href="{{ url('/products') }}" class="btn btn-outline-secondary btn-lg" style="border-radius: 15px; font-weight: 600;">
                    <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                </a>
            </div>
            @else
            <form method="POST" action="{{ url('/cart/add/' . $product->id) }}" class="mb-3 ajax-add-to-cart">
                @csrf
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label for="quantity" class="form-label">Số lượng:</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" max="99">
                    </div>
                    <div class="col-md-9 d-flex gap-2">
                        <button type="submit" class="btn btn-add-cart w-100 flex-grow-1 text-white">
                            <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection