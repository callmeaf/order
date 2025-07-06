<?php

return [
    'mail' => [
        'created' => [
            'subject' => 'Your order has been submitted – Ref: :code',
            'title' => "Order :code submitted successfully",
            'body' => "Thank you! We've received your order. You can track its status using the reference code :code in your dashboard.",
            'button' => 'View Order',
            'footer' => "Sales Team",
            'notification_subject' => "New order received",
            'notification_payload' => "🛒 A new order has been placed.\nReference code: :code\nYou'll be notified once it's processed.",
        ]
    ],
];
