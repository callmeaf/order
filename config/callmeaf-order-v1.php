<?php

use Callmeaf\Base\App\Enums\RequestType;

return [
    'model' => \Callmeaf\Order\App\Models\Order::class,
    'route_key_name' => 'code',
    'repo' => \Callmeaf\Order\App\Repo\V1\OrderRepo::class,
    'resources' => [
        RequestType::API->value => [
            'resource' => \Callmeaf\Order\App\Http\Resources\Api\V1\OrderResource::class,
            'resource_collection' => \Callmeaf\Order\App\Http\Resources\Api\V1\OrderCollection::class,
        ],
        RequestType::WEB->value => [
            'resource' => \Callmeaf\Order\App\Http\Resources\Web\V1\OrderResource::class,
            'resource_collection' => \Callmeaf\Order\App\Http\Resources\Web\V1\OrderCollection::class,
        ],
        RequestType::ADMIN->value => [
            'resource' => \Callmeaf\Order\App\Http\Resources\Admin\V1\OrderResource::class,
            'resource_collection' => \Callmeaf\Order\App\Http\Resources\Admin\V1\OrderCollection::class,
        ],
    ],
    'events' => [
        RequestType::API->value => [
            \Callmeaf\Order\App\Events\Api\V1\OrderIndexed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderCreated::class => [
                \Callmeaf\Order\App\Listeners\Api\V1\EmptyUserCart::class,
                \Callmeaf\Order\App\Listeners\Api\V1\DecreaseVariantStock::class,
                \Callmeaf\Order\App\Listeners\Api\V1\NotifyOrderCreated::class,
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderShowed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderDeleted::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Api\V1\OrderTypeUpdated::class => [
                // listeners
            ],
        ],
        RequestType::WEB->value => [
            \Callmeaf\Order\App\Events\Web\V1\OrderIndexed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderCreated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderShowed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderDeleted::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Web\V1\OrderTypeUpdated::class => [
                // listeners
            ],
        ],
        RequestType::ADMIN->value => [
            \Callmeaf\Order\App\Events\Admin\V1\OrderIndexed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderCreated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderShowed::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderDeleted::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Order\App\Events\Admin\V1\OrderTypeUpdated::class => [
                // listeners
            ],
        ],
    ],
    'requests' => [
        RequestType::API->value => [
            'index' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderIndexRequest::class,
            'store' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderStoreRequest::class,
            'show' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderShowRequest::class,
            'update' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderUpdateRequest::class,
            'destroy' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Order\App\Http\Requests\Api\V1\OrderTypeUpdateRequest::class,
        ],
        RequestType::WEB->value => [
            'index' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderIndexRequest::class,
            'create' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderCreateRequest::class,
            'store' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderStoreRequest::class,
            'show' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderShowRequest::class,
            'edit' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderEditRequest::class,
            'update' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderUpdateRequest::class,
            'destroy' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Order\App\Http\Requests\Web\V1\OrderTypeUpdateRequest::class,
        ],
        RequestType::ADMIN->value => [
            'index' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderIndexRequest::class,
            'store' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderStoreRequest::class,
            'show' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderShowRequest::class,
            'update' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderUpdateRequest::class,
            'destroy' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Order\App\Http\Requests\Admin\V1\OrderTypeUpdateRequest::class,
        ],
    ],
    'controllers' => [
        RequestType::API->value => [
            'order' => \Callmeaf\Order\App\Http\Controllers\Api\V1\OrderController::class,
        ],
        RequestType::WEB->value => [
            'order' => \Callmeaf\Order\App\Http\Controllers\Web\V1\OrderController::class,
        ],
        RequestType::ADMIN->value => [
            'order' => \Callmeaf\Order\App\Http\Controllers\Admin\V1\OrderController::class,
        ],
    ],
    'routes' => [
        RequestType::API->value => [
            'prefix' => 'orders',
            'as' => 'orders.',
            'middleware' => [
                'auth:sanctum',
            ],
        ],
        RequestType::WEB->value => [
            'prefix' => 'orders',
            'as' => 'orders.',
            'middleware' => [
                'route_status:' . \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND
            ],
        ],
        RequestType::ADMIN->value => [
            'prefix' => 'orders',
            'as' => 'orders.',
            'middleware' => [
                'auth:sanctum',
                'role:' . \Callmeaf\Role\App\Enums\RoleName::SUPER_ADMIN->value
            ],
        ],
    ],
    'enums' => [
         'status' => \Callmeaf\Order\App\Enums\OrderStatus::class,
         'type' => \Callmeaf\Order\App\Enums\OrderType::class,
    ],
     'exports' => [
        RequestType::API->value => [
            'excel' => \Callmeaf\Order\App\Exports\Api\V1\OrdersExport::class,
        ],
        RequestType::WEB->value => [
            'excel' => \Callmeaf\Order\App\Exports\Web\V1\OrdersExport::class,
        ],
        RequestType::ADMIN->value => [
            'excel' => \Callmeaf\Order\App\Exports\Admin\V1\OrdersExport::class,
        ],
     ],
     'imports' => [
         RequestType::API->value => [
             'excel' => \Callmeaf\Order\App\Imports\Api\V1\OrdersImport::class,
         ],
         RequestType::WEB->value => [
             'excel' => \Callmeaf\Order\App\Imports\Web\V1\OrdersImport::class,
         ],
         RequestType::ADMIN->value => [
             'excel' => \Callmeaf\Order\App\Imports\Admin\V1\OrdersImport::class,
         ],
     ],
    'code_length' => 6,
    "code_prefix" => 'callmeaf-'
];
