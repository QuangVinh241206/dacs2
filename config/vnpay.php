<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for VNPay payment gateway integration
    |
    */

    'tmn_code' => env('VNPAY_TMN_CODE', 'YOUR_TMNCODE'),
    'hash_secret' => env('VNPAY_HASH_SECRET', 'YOUR_HASHSECRET'),
    'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'return_url' => env('VNPAY_RETURN_URL', null),
];