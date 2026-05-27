<?php

return [
    'prefer_local_media' => env('BAKERY_PREFER_LOCAL_MEDIA', false),
    'name' => env('BAKERY_NAME', 'Mana Ooru Mana Tea'),
    'currency' => env('BAKERY_CURRENCY', 'INR'),
    'currency_symbol' => env('BAKERY_CURRENCY_SYMBOL', '₹'),
    'tax_rate' => (float) env('BAKERY_TAX_RATE', 0.05),
    'free_delivery_threshold' => (float) env('BAKERY_FREE_DELIVERY_THRESHOLD', 500),
    'default_delivery_charge' => (float) env('BAKERY_DELIVERY_CHARGE', 50),
    'low_stock_threshold' => (int) env('BAKERY_LOW_STOCK_THRESHOLD', 5),
    'loyalty_points_per_rupee' => (float) env('BAKERY_LOYALTY_RATE', 0.1),

    'order_statuses' => [
        'pending',
        'confirmed',
        'processing',
        'shipped',
        'delivered',
        'cancelled',
    ],

    'payment_methods' => ['razorpay', 'stripe', 'upi', 'cod'],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY_ID', env('RAZORPAY_KEY')),
        'secret' => env('RAZORPAY_KEY_SECRET', env('RAZORPAY_SECRET')),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],
];
