<?php

return [
    'vietqr' => [
        'bank_id'      => env('VIETQR_BANK_ID', 'MB'),
        'account_no'   => env('VIETQR_ACCOUNT_NO'),
        'account_name' => env('VIETQR_ACCOUNT_NAME'),
    ],

    'vnpay' => [
        'tmn_code'    => env('VNPAY_TMN_CODE'),
        'hash_secret' => env('VNPAY_HASH_SECRET'),
    ],
];