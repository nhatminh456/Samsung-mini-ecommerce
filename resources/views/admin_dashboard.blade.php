@extends('base')

@section('title', 'Thống Kê Tổng Quan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-line text-primary me-2"></i> Bảng Điều Khiển (Dashboard)</h2>
</div>

<!-- Các thẻ thống kê nhanh -->
<div class="row mb-4">
    <!-- Doanh thu -->
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #0f766e, #124f77); border: none; border-radius: 16px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-light" style="font-size: 0.9rem;">Tổng Doanh Thu</p>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h4>
                    </div>
                    <div class="fs-1 text-white opacity-50">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Đơn hàng -->
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary" style="border: none; border-radius: 16px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-light" style="font-size: 0.9rem;">Tổng Đơn Hàng</p>
                        <h4 class="mb-0 fw-bold">{{ $totalOrders }}</h4>
                    </div>
                    <div class="fs-1 text-white opacity-50">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm -->
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success" style="border: none; border-radius: 16px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-light" style="font-size: 0.9rem;">Tổng Sản Phẩm</p>
                        <h4 class="mb-0 fw-bold">{{ $totalProducts }}</h4>
                    </div>
                    <div class="fs-1 text-white opacity-50">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Khách hàng -->
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning" style="border: none; border-radius: 16px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-dark" style="font-size: 0.9rem;">Khách Hàng</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalUsers }}</h4>
                    </div>
                    <div class="fs-1 text-dark opacity-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Phân tích trạng thái đơn -->
    <div class="col-md-4 mb-4">
        <div class="card border-secondary bg-dark text-light h-100">
            <div class="card-header border-secondary">
                <h5 class="mb-0">Trạng Thái Đơn Hàng</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-dark text-light">
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary">
                        <span><i class="fas fa-clock text-warning me-2"></i> Chờ xử lý</span>
                        <span class="badge bg-warning rounded-pill text-dark">{{ $pendingCount }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary">
                        <span><i class="fas fa-spinner text-info me-2"></i> Đang xử lý</span>
                        <span class="badge bg-info rounded-pill text-dark">{{ $processingCount }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary">
                        <span><i class="fas fa-truck text-primary me-2"></i> Đang giao</span>
                        <span class="badge bg-primary rounded-pill">{{ $shippedCount }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary">
                        <span><i class="fas fa-check-circle text-success me-2"></i> Thành công</span>
                        <span class="badge bg-success rounded-pill">{{ $deliveredCount }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary">
                        <span><i class="fas fa-times-circle text-danger me-2"></i> Đã hủy</span>
                        <span class="badge bg-danger rounded-pill">{{ $cancelledCount }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Đơn hàng gần đây -->
    <div class="col-md-8 mb-4">
        <div class="card border-secondary bg-dark text-light h-100">
            <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Đơn Hàng Gần Đây</h5>
                <a href="/admin/orders" class="btn btn-sm btn-outline-light">Xem Tất Cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách Hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Ngày Đặt</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="/admin/order/{{ $order->id }}" class="text-info fw-bold">#{{ $order->id }}</a></td>
                                <td>{{ $order->shipping_name }}</td>
                                <td><span class="text-success fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span></td>
                                <td>{{ date('d/m/Y H:i', strtotime($order->order_date)) }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Chờ xử lý</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info text-dark"><i class="fas fa-spinner fa-spin"></i> Đang xử lý</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-primary"><i class="fas fa-truck"></i> Đang giao</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Đã giao</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Chưa có đơn hàng nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection