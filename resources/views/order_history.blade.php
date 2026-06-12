@extends('base')

@section('title', 'Lịch sử đơn hàng - SAMSUNG')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="fas fa-history text-primary me-2"></i>Lịch sử đơn hàng</h2>
        <a href="{{ url('/products') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Tiếp tục mua sắm
        </a>
    </div>
    
    @if(isset($orders) && count($orders) > 0)
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Mã đơn hàng</th>
                            <th class="py-3">Ngày đặt</th>
                            <th class="py-3">Tổng tiền</th>
                            <th class="py-3">Thanh toán</th>
                            <th class="py-3">Trạng thái</th>
                            <th class="py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td class="px-4 text-dark">
                                <span class="badge bg-light text-dark border">{{ $order->id }}</span>
                            </td>
                            
                            <td class="text-muted">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                            
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                            
                            <td>
                                @if ($order->payment_status === 'paid')
                                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle"></i> Đã thanh toán</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle"></i> Chưa TT</span>
                                @endif
                            </td>

                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Chờ xử lý</span>
                                @elseif ($order->status == 'processing')
                                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Đang xử lý</span>
                                @elseif ($order->status == 'shipping')
                                    <span class="badge bg-primary px-3 py-2 rounded-pill">Đang giao</span>
                                @elseif ($order->status == 'delivered')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Đã giao</span>
                                @elseif ($order->status == 'cancelled')
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-eye me-1"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card shadow-sm border-0 rounded-4 text-center py-5 mt-4">
        <div class="card-body">
            <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-25"></i>
            <h4 class="text-dark fw-bold">Bạn chưa có đơn hàng nào</h4>
            <p class="text-muted mb-4">Hãy khám phá và mua sắm các sản phẩm công nghệ tuyệt vời của chúng tôi!</p>
            <a href="{{ url('/products') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                <i class="fas fa-shopping-bag me-1"></i> Mua sắm ngay
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
