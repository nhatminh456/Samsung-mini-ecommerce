@extends('base')

@section('title', 'Thanh toán - SAMSUM Center')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">
        <i class="fas fa-credit-card"></i> Thanh toán đơn hàng
    </h2>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/checkout') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại *</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="0912345678" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ giao hàng *</label>
                            <textarea class="form-control" name="address" rows="3" 
                                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phương thức thanh toán *</label>
                            <div class="payment-options">
                                <div class="form-check p-3 mb-2 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="cod" value="COD" {{ old('payment_method', 'COD') == 'COD' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="cod">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <br><small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                    </label>
                                </div>
                                <div class="form-check p-3 mb-2 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="bank" value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="bank">
                                        <i class="fas fa-university text-info"></i>
                                        <strong>Chuyển khoản ngân hàng</strong>
                                        <br><small class="text-muted">Chuyển khoản qua ngân hàng</small>
                                    </label>
                                </div>
                                <div class="form-check p-3 mb-2 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="ewallet" value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="ewallet">
                                        <i class="fas fa-wallet text-warning"></i>
                                        <strong>Ví điện tử (MoMo, ZaloPay)</strong>
                                        <br><small class="text-muted">Thanh toán qua ví điện tử</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ghi chú đơn hàng (tùy chọn)</label>
                            <textarea class="form-control" name="notes" rows="2" 
                                      placeholder="Ví dụ: Giao hàng giờ hành chính, gọi trước khi giao...">{{ old('notes') }}</textarea>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Đặt hàng ngay
                            </button>
                            <a href="{{ url('/cart') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Đơn hàng của bạn</h5>
                </div>
                <div class="card-body">
                    <div class="order-items" style="max-height: 350px; overflow-y: auto;">
                        @foreach ($cart as $item)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <img src="{{ asset($item->image_url) }}" 
                                 alt="{{ $item->name }}" 
                                 class="rounded shadow-sm"
                                 style="width: 70px; height: 70px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/70x70?text={{ urlencode($item->name) }}'">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1">{{ $item->name }}</h6>
                                <small class="text-muted">Số lượng: <strong>{{ $item->quantity }}</strong></small>
                                <div class="text-danger fw-bold mt-1">
                                    {{ number_format($item->subtotal, 0, ',', '.') }} ₫
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <strong>{{ number_format($total, 0, ',', '.') }} ₫</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <strong class="text-success">Miễn phí</strong>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tổng cộng:</h5>
                            <h4 class="mb-0 text-danger fw-bold">{{ number_format($total, 0, ',', '.') }} ₫</h4>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle"></i>
                        <small>Đơn hàng sẽ được giao trong <strong>2-3 ngày</strong> làm việc</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection