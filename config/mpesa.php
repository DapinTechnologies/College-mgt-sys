<?php
return [
    'shortcode' => env('MPESA_SHORT_CODE',''),
    'till' => env('MPESA_TILL_NUMBER',''),
    'passkey' => env('MPESA_PASS_KEY',''),
    'consumerkey' => env('MPESA_CONSUMER_KEY',''),
    'consumersecret' => env('MPESA_CONSUMER_SECRET', ''),
    'shortcode_type' => env('MPESA_SHORTCODE_TYPE', ''),
    'shortcode_sandbox' => env('MPESA_SHORT_CODE_SANDBOX',''),
    'passkey_sandbox' => env('MPESA_PASS_KEY_SANDBOX',''),
    'consumerkey_sandbox' => env('MPESA_CONSUMER_KEY_SANDBOX',''),
    'consumersecret_sandbox' => env('MPESA_CONSUMER_SECRET_SANDBOX', ''),
    'status' => env('MPESA_STATUS', 'sandbox'), // Set 'sandbox' as default
];
