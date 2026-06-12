@extends('base')

@section('title', 'Thanh toán - SAMSUM Center')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">
        <i class="fas fa-credit-card"></i> Thanh toán đơn hàng
    </h2>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Thông tin giao hàng</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ url('/checkout') }}">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên *</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại *</label>
                                <input type="tel" class="form-control" name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="0912345678" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ giao hàng *</label>
                            <textarea class="form-control" name="address" rows="3"
                                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3 mt-4">
                            <label class="form-label fw-bold">Phương thức thanh toán *</label>
                            <div class="payment-options">

                                {{-- COD --}}
                                <div class="form-check p-3 mb-2 border rounded border-primary">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                           id="cod" value="COD"
                                           {{ old('payment_method', 'COD') == 'COD' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="cod">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <br><small class="text-muted ms-4">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                    </label>
                                </div>

                                {{-- Chuyển khoản ngân hàng --}}
                                <div class="form-check p-3 mb-2 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                           id="bank" value="bank_transfer"
                                           {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="bank">
                                        <i class="fas fa-university text-info me-2"></i>
                                        <strong>Chuyển khoản ngân hàng</strong>
                                        <br><small class="text-muted ms-4">Quét mã QR để chuyển khoản — xác nhận tự động</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ghi chú đơn hàng (tùy chọn)</label>
                            <textarea class="form-control" name="notes" rows="2"
                                      placeholder="Ví dụ: Giao hàng giờ hành chính, gọi trước khi giao...">{{ old('notes') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                <i class="fas fa-check-circle me-2"></i> Đặt hàng ngay
                            </button>
                            <a href="{{ url('/cart') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag text-primary"></i> Đơn hàng của bạn</h5>
                </div>
                <div class="card-body">
                    <div class="order-items pe-2" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($cart as $item)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <img src="{{ asset($item->image_url ?? 'images/default.jpg') }}"
                                 alt="{{ $item->name }}"
                                 class="rounded shadow-sm"
                                 style="width: 70px; height: 70px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/70x70?text={{ urlencode($item->name) }}'">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark">{{ $item->name }}</h6>
                                
                                @if(isset($item->color) || isset($item->storage))
                                    <div class="mb-1">
                                        <span class="badge bg-secondary text-white" style="font-size: 0.75rem;">
                                            {{ $item->color ?? '' }} {{ (isset($item->color) && isset($item->storage)) ? '|' : '' }} {{ $item->storage ?? '' }}
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">SL: <strong>{{ $item->quantity }}</strong></small>
                                    <div class="text-danger fw-bold">
                                        {{ number_format($item->subtotal, 0, ',', '.') }} ₫
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-top pt-3 mt-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính:</span>
                            <strong>{{ number_format($total, 0, ',', '.') }} ₫</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <strong class="text-success">Miễn phí</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-bold">Tổng cộng:</h5>
                            <h4 class="mb-0 text-danger fw-bold">{{ number_format($total, 0, ',', '.') }} ₫</h4>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0 border-0 bg-light shadow-sm">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        <small>Đơn hàng sẽ được giao trong <strong>2-3 ngày</strong> làm việc</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection