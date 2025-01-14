<?php

return [
    'model' => \Callmeaf\Order\Models\OrderItem::class,
    'model_resource' => \Callmeaf\Order\Http\Resources\V1\Api\OrderItemResource::class,
    'model_resource_collection' => \Callmeaf\Order\Http\Resources\V1\Api\OrderItemCollection::class,
    'service' => \Callmeaf\Order\Services\V1\OrderItemService::class,
    'default_values' => [
        'status' => \Callmeaf\Order\Enums\OrderItemStatus::PENDING,
    ],
    'events' => [
        \Callmeaf\Order\Events\OrderItemUpdated::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderItemStatusUpdated::class => [
            // listeners
        ],
        \Callmeaf\Order\Events\OrderItemDestroyed::class => [
            // listeners
        ],
    ],
    'validations' => [
        'order_item' => \Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemFormRequestValidator::class,
    ],
    'resources' => [
        'order_item' => \Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemResources::class,
    ],
    'controllers' => [
        'order_items' => \Callmeaf\Order\Http\Controllers\V1\Api\OrderItemController::class,
    ],
    'form_request_authorizers' => [
        'order_item' => \Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'order_item' => \Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemControllerMiddleware::class,
    ],
    'searcher' => \Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemSearcher::class,
];
