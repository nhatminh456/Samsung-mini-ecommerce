@extends('base')

@section('title', 'Giỏ hàng - SAMSUM Center')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">
        <i class="bi bi-cart3"></i> Giỏ hàng của bạn
    </h2>

    @if (isset($cart) && count($cart) > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->image_url ?? 'images/default.jpg') }}" 
                                                 alt="{{ $item->name }}" 
                                                 class="rounded shadow-sm"
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 onerror="this.src='https://placehold.co/80x80?text={{ urlencode($item->name) }}'">
                                            <div class="ms-3">
                                                <h6 class="mb-1 fw-bold">{{ $item->name }}</h6>
                                                
                                                @if(isset($item->color) || isset($item->storage))
                                                    <span class="badge bg-secondary text-white mb-1">
                                                        {{ $item->color ?? '' }} {{ (isset($item->color) && isset($item->storage)) ? '|' : '' }} {{ $item->storage ?? '' }}
                                                    </span>
                                                    <br>
                                                @endif
                                                
                                                <small class="text-muted">ID Phân loại: {{ $item->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($item->price, 0, ',', '.') }} VNĐ</strong>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ url('/cart/update/' . $item->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" 
                                                       max="99"
                                                       class="form-control text-center">
                                                <button type="submit" class="btn btn-outline-primary" title="Cập nhật">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ number_format($item->subtotal, 0, ',', '.') }} VNĐ</strong>
                                    </td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ url('/cart/remove/' . $item->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <form method="POST" action="{{ url('/cart/clear') }}" class="d-inline" onsubmit="return confirmClearAll(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash3"></i> Xóa tất cả
                            </button>
                        </form>
                        <a href="{{ url('/products') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4 fw-bold">Tổng đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <strong>{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <strong class="text-success">Miễn phí</strong>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="mb-0 fw-bold">Tổng cộng:</h5>
                        <h5 class="mb-0 text-primary fw-bold">{{ number_format($total, 0, ',', '.') }} VNĐ</h5>
                    </div>

                    <a href="{{ url('/checkout') }}" class="btn btn-primary btn-lg w-100 mb-3 fw-bold">
                        <i class="bi bi-credit-card me-2"></i> Thanh toán ngay
                    </a>

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check text-success"></i> Thanh toán an toàn & bảo mật
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-5 bg-light rounded-3 shadow-sm mt-4">
        <i class="bi bi-cart-x display-1 text-muted mb-3 d-block"></i>
        <h3 class="fw-bold">Giỏ hàng trống</h3>
        <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
        <a href="{{ url('/products') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-bag-plus me-2"></i> Khám phá sản phẩm
        </a>
    </div>
    @endif
</div>

<div id="clearModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; padding:30px; border-radius:15px; max-width:400px; text-align:center; box-shadow:0 10px 40px rgba(0,0,0,0.3);">
        <h5 style="margin-bottom:15px; color:#333; font-weight:bold;">Xóa toàn bộ giỏ hàng?</h5>
        <div style="margin-top:25px;">
            <button onclick="cancelClear()" style="padding:10px 30px; margin:0 10px; border:1px solid #ccc; background:white; border-radius:25px; cursor:pointer; font-weight:500;">Hủy</button>
            <button onclick="confirmClearAction()" style="padding:10px 30px; margin:0 10px; border:none; background:#dc3545; color:white; border-radius:25px; cursor:pointer; font-weight:500;">Xóa ngay</button>
        </div>
    </div>
</div>

<script>
let currentForm = null;

function confirmClearAll(event) {
    event.preventDefault();
    currentForm = event.target;
    document.getElementById('clearModal').style.display = 'flex';
    return false;
}

function confirmClearAction() {
    if (currentForm) {
        currentForm.submit();
    }
}

function cancelClear() {
    document.getElementById('clearModal').style.display = 'none';
    currentForm = null;
}
</script>
@endsection