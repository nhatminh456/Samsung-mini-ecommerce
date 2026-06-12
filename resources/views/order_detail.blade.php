@extends('base')

@section('title', 'Chi tiết đơn hàng #' . $order->id . ' - SAMSUM')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Chi tiết đơn hàng</h2>
                <a href="{{ url('/orders') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            {{-- Thông báo --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Card thông tin đơn hàng --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') : 'N/A' }}</p>
                            <p><strong>Trạng thái:</strong>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif ($order->status == 'processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                @elseif ($order->status == 'shipping')
                                    <span class="badge bg-primary">Đang giao</span>
                                @elseif ($order->status == 'delivered')
                                    <span class="badge bg-success">Đã giao</span>
                                @elseif ($order->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @endif
                            </p>
                            <p><strong>Thanh toán:</strong>
                                @if ($order->payment_status === 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-secondary">Chưa thanh toán</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>Phương thức thanh toán:</strong>
                                @if ($order->payment_method === 'bank_transfer')
                                    <span class="badge bg-info text-dark"><i class="fas fa-university"></i> Chuyển khoản ngân hàng</span>
                                @elseif ($order->payment_method === 'e_wallet')
                                    <span class="badge bg-purple" style="background:#6f42c1"><i class="fas fa-wallet"></i> Ví điện tử (VNPAY)</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-money-bill"></i> COD</span>
                                @endif
                            </p>
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

            {{-- QR VietQR - Chỉ hiện khi chọn chuyển khoản và chưa thanh toán --}}
            @if ($order->payment_method === 'bank_transfer' && ($order->payment_status ?? 'unpaid') !== 'paid' && $order->status !== 'cancelled')
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-qrcode"></i> Thanh toán chuyển khoản ngân hàng</h5>
                </div>
                <div class="card-body text-center">
                    <p class="mb-1">Quét mã QR bằng app ngân hàng để thanh toán <strong>đúng số tiền và nội dung</strong>:</p>

                    <img src="{{ \App\Helpers\VietQRHelper::generateQR($order) }}"
                         alt="QR chuyển khoản"
                         class="my-3 border rounded"
                         //thước QR code cố định để tránh layout bị thay đổi khi có mã QR dài hơn
                         style="width: 100%; max-width: 50%; height: 300%;">

                    <div class="alert alert-info text-start mt-2">
                        <p class="mb-1"><i class="fas fa-university"></i> <strong>Ngân hàng:</strong> {{ config('payment.vietqr.bank_id') }}</p>
                        <p class="mb-1"><i class="fas fa-credit-card"></i> <strong>Số tài khoản:</strong> {{ config('payment.vietqr.account_no') }}</p>
                        <p class="mb-1"><i class="fas fa-user"></i> <strong>Chủ tài khoản:</strong> {{ config('payment.vietqr.account_name') }}</p>
                        <p class="mb-1"><i class="fas fa-money-bill"></i> <strong>Số tiền:</strong>
                            <span class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                        </p>
                        <p class="mb-0"><i class="fas fa-comment"></i> <strong>Nội dung chuyển khoản:</strong>
                            <span class="text-danger fw-bold">DH{{ $order->id }}</span>
                        </p>
                    </div>

                    <div class="alert alert-warning mt-2 text-start">
                        <i class="fas fa-exclamation-triangle"></i>
                        Vui lòng chuyển khoản <strong>đúng nội dung "DH{{ $order->id }}"</strong>
                        để đơn hàng được xác nhận nhanh nhất. Đơn hàng sẽ được xử lý sau khi admin xác nhận thanh toán.
                    </div>
                </div>
            </div>
            @endif

            {{-- VNPAY - Chỉ hiện khi chọn ví điện tử và chưa thanh toán --}}
            @if ($order->payment_method === 'e_wallet' && ($order->payment_status ?? 'unpaid') !== 'paid' && $order->status !== 'cancelled')
            <div class="card mb-4 border-primary">
                <div class="card-header text-white" style="background:#6f42c1">
                    <h5 class="mb-0"><i class="fas fa-wallet"></i> Thanh toán qua VNPAY</h5>
                </div>
                <div class="card-body text-center">
                    <p>Đơn hàng của bạn chưa được thanh toán. Nhấn nút bên dưới để tiến hành thanh toán qua VNPAY.</p>
                    <a href="{{ route('payment.vnpay.create', $order->id) }}" class="btn btn-lg text-white" style="background:#6f42c1">
                        <i class="fas fa-wallet"></i> Thanh toán ngay qua VNPAY
                    </a>
                    <p class="text-muted mt-2 small">Hỗ trợ: MoMo, ZaloPay, thẻ ATM nội địa, thẻ quốc tế</p>
                </div>
            </div>
            @endif

            {{-- Đã thanh toán --}}
            @if (($order->payment_status ?? '') === 'paid')
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle"></i> Đơn hàng đã được thanh toán thành công. Cảm ơn bạn!
            </div>
            @endif

            {{-- Card sản phẩm --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->product_price, 0, ',', '.') }} ₫</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-bold">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td class="text-danger fw-bold fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Nút hủy đơn --}}
            @if ($order->status === 'pending' && $order->user_id === auth()->id())
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                <i class="fas fa-times-circle"></i> Hủy đơn hàng
            </button>

            <!-- Modal Xác nhận Hủy đơn (Tránh dùng confirm mặc định của trình duyệt) -->
            <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title text-danger fw-bold" id="cancelOrderModalLabel">
                                <i class="fas fa-exclamation-triangle"></i> Xác nhận hủy đơn
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <p class="mb-1 fs-5">Bạn có chắc chắn muốn hủy đơn hàng <strong>#{{ $order->id }}</strong> không?</p>
                            <small class="text-muted">Hành động này không thể hoàn tác.</small>
                        </div>
                        <div class="modal-footer border-top-0 pt-0 d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Đóng</button>
                            <form action="{{ url('/orders/cancel/' . $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="fas fa-check"></i> Có, chắn chắn hủy
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection