<?php

namespace App\Helpers;

use App\Models\Order;

class VietQRHelper
{
    public static function generateQR(Order $order): string
    {
        $bankId   = config('payment.vietqr.bank_id');    // VD: 'MB', 'VCB', 'TCB'
        $account  = config('payment.vietqr.account_no'); // Số tài khoản
        $name     = config('payment.vietqr.account_name');
        $amount   = $order->total_amount;
        $memo     = 'DH' . $order->id; // Nội dung CK để đối soát

        return "https://img.vietqr.io/image/{$bankId}-{$account}-compact2.png"
            . "?amount={$amount}&addInfo=" . urlencode($memo)
            . "&accountName=" . urlencode($name);
    }
}