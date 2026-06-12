@extends('base')

@section('title', 'Quản lý đơn hàng - Admin')

@section('content')
<div class="container-fluid my-4">
    
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->id }}</strong></td>
                            <td>
                                {{ $order->shipping_name ?: 'N/A' }}<br>
                                <small class="text-muted">{{ $order->user_email }}</small>
                            </td>
                            <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                @elseif ($order->status == 'processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                @elseif ($order->status == 'shipping')
                                    <span class="badge bg-primary">Đang giao</span>
                                @elseif ($order->status == 'delivered')
                                    <span class="badge bg-success">Đã giao</span>
                                @elseif ($order->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/admin/order/' . $order->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <form action="{{ url('/admin/order/delete/' . $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Mọi dữ liệu liên quan sẽ bị xóa.');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-info text-center m-0">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <h5>Chưa có đơn hàng nào</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection