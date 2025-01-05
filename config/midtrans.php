<?php

return [
    // Production Keys
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    // Sandbox Keys
    'sandbox_client_key' => env('MIDTRANS_SANDBOX_CLIENT_KEY', ''),
    'sandbox_server_key' => env('MIDTRANS_SANDBOX_SERVER_KEY', ''),

    // Environment & Settings
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    // Helper methods
    'current_client_key' => env('MIDTRANS_IS_PRODUCTION', false) ?
        env('MIDTRANS_CLIENT_KEY', '') :
        env('MIDTRANS_SANDBOX_CLIENT_KEY', ''),

    'current_server_key' => env('MIDTRANS_IS_PRODUCTION', false) ?
        env('MIDTRANS_SERVER_KEY', '') :
        env('MIDTRANS_SANDBOX_SERVER_KEY', ''),
];