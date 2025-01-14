<?php

use \Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function () {
    // Orders
    Route::apiResource('orders', config('callmeaf-order.controllers.orders'));
    Route::prefix('orders')->as('orders.')->controller(config('callmeaf-order.controllers.orders'))->group(function () {
        Route::prefix('{order}')->group(function () {
            Route::patch('/status', 'statusUpdate')->name('status_update');
            Route::patch('/restore', 'restore')->name('restore');
            Route::delete('/force', 'forceDestroy')->name('force_destroy');
            Route::post('/apply_voucher','applyVoucher')->name('apply_voucher');
            Route::post('/remove_voucher','removeVoucher')->name('remove_voucher');
        });
        Route::get('/trashed/index', 'trashed')->name('trashed.index');
    });
    // Order Items
    Route::apiResource('order_items', config('callmeaf-order-item.controllers.order_items'))->only([
        'update',
        'destroy'
    ]);
    Route::prefix('order_items')->as('order_items.')->controller(config('callmeaf-order-item.controllers.order_items'))->group(function () {
        Route::prefix('{order_item}')->group(function () {
            Route::patch('/status', 'statusUpdate')->name('status_update');
        });
    });
});

