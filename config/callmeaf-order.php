<?php

return [
    'model' => \Callmeaf\Order\Models\Order::class,
    'model_resource' => \Callmeaf\Order\Http\Resources\V1\Api\OrderResource::class,
    'model_resource_collection' => \Callmeaf\Order\Http\Resources\V1\Api\OrderCollection::class,
    'service' => \Callmeaf\Order\Services\V1\OrderService::class,
    'default_values' => [
        'status' => \Callmeaf\Order\Enums\OrderStatus::PENDING,
    ],
    'events' => [
        \Callmeaf\Order\Events\OrderIndexed::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderStored::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderShowed::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderUpdated::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderStatusUpdated::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderDestroyed::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderRestored::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderTrashed::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderForceDestroyed::class => [
            // listeners
        ],
    ],
    'validations' => [
        'order' => \Callmeaf\Order\Utilities\V1\Api\Order\OrderFormRequestValidator::class,
    ],
    'resources' => [
        'order' => \Callmeaf\Order\Utilities\V1\Api\Order\OrderResources::class,
    ],
    'controllers' => [
        'orders' => \Callmeaf\Order\Http\Controllers\V1\Api\OrderController::class,
    ],
    'form_request_authorizers' => [
        'order' => \Callmeaf\Order\Utilities\V1\Api\Order\OrderFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'order' => \Callmeaf\Order\Utilities\V1\Api\Order\OrderControllerMiddleware::class,
    ],
    'searcher' => \Callmeaf\Order\Utilities\V1\Api\Order\OrderSearcher::class,
    'prefix_ref_code' => 'callmeaf-',
    // current length without calculate prefix_ref_code
    'ref_code_length' => 6,
];
