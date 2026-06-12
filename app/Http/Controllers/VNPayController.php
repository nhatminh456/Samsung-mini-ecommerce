<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class VNPayController extends Controller
{
    public function createPayment(Order $order)
    {
        $vnp_TmnCode    = config('payment.vnpay.tmn_code');
        $vnp_HashSecret = config('payment.vnpay.hash_secret');
        $vnp_Url        = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_ReturnUrl  = route('payment.vnpay.return');

        $inputData = [
            'vnp_Version'    => '2.1.0',
            'vnp_TmnCode'    => $vnp_TmnCode,
            'vnp_Amount'     => $order->total_amount * 100,
            'vnp_Command'    => 'pay',
            'vnp_CreateDate' => now()->format('YmdHis'),
            'vnp_CurrCode'   => 'VND',
            'vnp_IpAddr'     => request()->ip(),
            'vnp_Locale'     => 'vn',
            'vnp_OrderInfo'  => 'Thanh toan don hang #' . $order->id,
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $vnp_ReturnUrl,
            'vnp_TxnRef'     => $order->id . '_' . time(),
        ];

        ksort($inputData);
        $hashData   = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $inputData['vnp_SecureHash'] = $secureHash;

        return redirect($vnp_Url . '?' . http_build_query($inputData));
    }

    public function returnPayment(Request $request)
    {
        $vnp_HashSecret = config('payment.vnpay.hash_secret');
        $vnp_SecureHash = $request->vnp_SecureHash;

        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);
        $hashData   = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            return redirect()->route('checkout.index')
                ->with('error', ' Chữ ký không hợp lệ!');
        }

        $orderId = explode('_', $request->vnp_TxnRef)[0];
        $order   = Order::findOrFail($orderId);

        if ($request->vnp_ResponseCode === '00') {
            $order->update(['payment_status' => 'paid']);
            return redirect()->route('checkout.success', $order)
                ->with('success', ' Thanh toán thành công!');
        }

        return redirect()->route('checkout.index')
            ->with('error', ' Thanh toán thất bại, vui lòng thử lại!');
    }

    public function ipnPayment(Request $request)
    {
        $vnp_HashSecret = config('payment.vnpay.hash_secret');
        $vnp_SecureHash = $request->vnp_SecureHash;

        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);
        $hashData   = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        }

        $orderId = explode('_', $request->vnp_TxnRef)[0];
        $order   = Order::find($orderId);

        if (!$order) {
            return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['RspCode' => '02', 'Message' => 'Order already confirmed']);
        }

        if ($request->vnp_ResponseCode === '00') {
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
    }
}