@extends('base')

@section('title', 'Chi tiết đơn hàng #' . $order->id . ' - Admin')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Chi tiết đơn hàng (Admin)</h2>
                <div>
                    <a href="{{ url('/admin/orders') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <form action="{{ url('/admin/order/delete/' . $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ đơn hàng này?');">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                            <p><strong>User ID:</strong> {{ $order->user_id }}</p>
                            <p><strong>Email:</strong> {{ $order->user_email }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?: 'COD' }}</p>
                        </div>
                    </div>
                    
                    @if ($order->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Cập nhật trạng thái</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/order/update-status/' . $order->id) }}">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Trạng thái hiện tại: 
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
                                    @endif
                                </label>
                                <select name="status" class="form-select" required>
                                    <option value="">-- Chọn trạng thái mới --</option>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã SP</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_id }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->product_price, 0, ',', '.') }} ₫</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-bold">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td class="text-danger fw-bold fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
