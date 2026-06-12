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
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .product-detail-img:hover { transform: scale(1.02); }
    .product-title-main {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 1rem;
    }
    .product-price-main {
        font-size: 2.5rem;
        font-weight: 800;
        color: #000000;
        margin-bottom: 1.5rem;
    }
    .info-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .info-card h5 { color: #667eea; font-weight: 700; margin-bottom: 1rem; }
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
    .breadcrumb {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .thumbnail-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .thumbnail-img:hover, .thumbnail-img.active {
        border-color: #667eea;
        transform: translateY(-2px);
    }
    .variant-label {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
    }
    .btn-check:checked + .variant-label {
        background: linear-gradient(135deg, #02040f 0%, #f4edee 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }
</style>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row mt-4">
        {{-- CỘT TRÁI: ẢNH --}}
        <div class="col-md-5 mb-4">
            <img src="{{ asset('images/default.jpg') }}" 
                 id="mainProductImage" 
                 class="img-fluid product-detail-img mb-3" 
                 alt="{{ $product->name }}">
            
            <div id="thumbnail-container" class="d-flex gap-2 overflow-auto py-2"></div>
        </div>
        
        {{-- CỘT PHẢI: THÔNG TIN --}}
        <div class="col-md-7">
            <h1 class="product-title-main">{{ $product->name }}</h1>
            
            @if($product->is_bestseller)
            <span class="badge mb-3" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 0.6rem 1.2rem; font-size: 1rem; border-radius: 50px;">
                <i class="fas fa-fire"></i> Best Seller
            </span>
            @endif
            
            @php $firstVariant = $product->variants->first(); @endphp
            <h2 class="product-price-main" id="displayPrice">
                {{ $firstVariant ? number_format($firstVariant->price, 0, ',', '.') : 'Liên hệ' }} VNĐ
            </h2>
            
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i> Thông tin sản phẩm</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Danh mục:</strong> <span class="text-primary fw-bold">{{ $product->category->name ?? 'Chưa xác định' }}</span></li>
                    <li class="mb-0"><strong>Tình trạng kho:</strong> <span id="displayStock" class="text-success fw-bold">{{ $firstVariant ? $firstVariant->stock_quantity : 0 }}</span> sản phẩm</li>
                </ul>
            </div>
            
            @if(session('user_role') == 'admin')
                <div class="alert alert-warning mb-3 fw-bold">
                    <i class="fas fa-exclamation-triangle"></i> Tài khoản admin không có quyền đặt hàng.
                </div>
            @else
                <form method="POST" action="{{ url('/cart/add') }}" class="mb-4">
                    @csrf
                    
                    @if($product->variants->count() > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Chọn Phiên Bản:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->variants as $index => $variant)
                                <div>
                                    <input type="radio" class="btn-check variant-radio" 
                                           name="variant_id" 
                                           id="variant_{{ $variant->id }}" 
                                           value="{{ $variant->id }}" 
                                           data-price="{{ $variant->price }}" 
                                           data-stock="{{ $variant->stock_quantity }}"
                                           {{ $index == 0 ? 'checked' : '' }}>
                                    <label class="variant-label" for="variant_{{ $variant->id }}">
                                        {{ $variant->color }} - {{ $variant->storage }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="quantity" class="form-label fw-bold">Số lượng:</label>
                            <input type="number" class="form-control form-control-lg" name="quantity" id="quantity" value="1" min="1" max="99">
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-add-cart w-100 text-white btn-lg">
                                <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            @if($product->description)
            <div class="info-card mt-3">
                <h5><i class="fas fa-align-left me-2"></i> Mô tả chi tiết</h5>
                <p class="text-muted mb-0" style="white-space: pre-line;">{{ $product->description }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Dữ liệu ảnh theo từng variant
    const variantImages = {
        @foreach($product->variants as $variant)
        {{ $variant->id }}: [
            @foreach($variant->images as $img)
                "{{ asset($img->image_path) }}",
            @endforeach
        ],
        @endforeach
    };

    const defaultImage = "{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/default.jpg') }}";

    function loadVariantImages(variantId) {
        const images = variantImages[variantId] || [];
        const mainImg = document.getElementById('mainProductImage');
        const thumbContainer = document.getElementById('thumbnail-container');

        thumbContainer.innerHTML = '';

        if (images.length === 0) {
            mainImg.src = defaultImage;
            return;
        }

        // Hiện ảnh đầu tiên
        mainImg.src = images[0];

        // Tạo thumbnail
        images.forEach((url, index) => {
            const thumb = document.createElement('img');
            thumb.src = url;
            thumb.className = 'thumbnail-img' + (index === 0 ? ' active' : '');
            thumb.onclick = function() {
                mainImg.src = url;
                document.querySelectorAll('.thumbnail-img').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            };
            thumbContainer.appendChild(thumb);
        });
    }

    // Xử lý khi chọn variant
    document.querySelectorAll('.variant-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const price = this.getAttribute('data-price');
            const stock = this.getAttribute('data-stock');

            // Cập nhật giá
            document.getElementById('displayPrice').innerText =
                new Intl.NumberFormat('vi-VN').format(price) + ' VNĐ';

            // Cập nhật tồn kho
            document.getElementById('displayStock').innerText = stock;

            // Cập nhật max số lượng
            const qtyInput = document.getElementById('quantity');
            qtyInput.max = stock;
            if (parseInt(qtyInput.value) > parseInt(stock)) {
                qtyInput.value = stock;
            }

            // Đổi ảnh theo variant
            loadVariantImages(this.value);
        });
    });

    // Load ảnh variant đầu tiên khi vào trang
    const firstRadio = document.querySelector('.variant-radio');
    if (firstRadio) {
        loadVariantImages(firstRadio.value);
    } else {
        document.getElementById('mainProductImage').src = defaultImage;
    }
</script>
@endsection