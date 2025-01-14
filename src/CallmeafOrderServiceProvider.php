<?php

namespace Callmeaf\Order;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CallmeafOrderServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-order';
    private const CONFIGS_GROUP = 'callmeaf-order-config';
    private const CONFIGS_ORDER_ITEM_KEY = 'callmeaf-order-item';
    private const CONFIGS_ORDER_ITEM_GROUP = 'callmeaf-order-item-config';
    private const CONFIGS_ORDER_ITEM_DISCOUNT_KEY = 'callmeaf-order-item-discount';
    private const CONFIGS_ORDER_ITEM_DISCOUNT_GROUP = 'callmeaf-order-item-discount-config';
    private const ROUTES_DIR = __DIR__ . '/../routes';
    private const DATABASE_DIR = __DIR__ . '/../database';
    private const DATABASE_GROUPS = 'callmeaf-order-migrations';
    private const RESOURCES_DIR = __DIR__ . '/../resources';
    private const VIEWS_NAMESPACE = 'callmeaf-order';
    private const VIEWS_GROUP = 'callmeaf-order-views';
    private const LANG_DIR = __DIR__ . '/../lang';
    private const LANG_NAMESPACE = 'callmeaf-order';
    private const LANG_GROUP = 'callmeaf-order-lang';
    public function boot()
    {
        $this->registerConfig();
        $this->registerRoute();
        $this->registerMigration();
        $this->registerEvents();
        $this->registerViews();
        $this->registerLang();
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-order.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-order.php' => config_path('callmeaf-order.php'),
        ],self::CONFIGS_GROUP);

        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-order-item.php',self::CONFIGS_ORDER_ITEM_KEY);
        $this->publishes([
            self::CONFIGS_ORDER_ITEM_KEY . '/callmeaf-order-item.php' => config_path('callmeaf-order-item.php'),
        ],self::CONFIGS_ORDER_ITEM_GROUP);

        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-order-item-discount.php',self::CONFIGS_ORDER_ITEM_DISCOUNT_KEY);
        $this->publishes([
            self::CONFIGS_ORDER_ITEM_DISCOUNT_KEY . '/callmeaf-order-item-discount.php' => config_path('callmeaf-order-item.php'),
        ],self::CONFIGS_ORDER_ITEM_DISCOUNT_GROUP);
    }

    private function registerRoute(): void
    {
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/api.php');
    }

    private function registerMigration(): void
    {
        $this->loadMigrationsFrom(self::DATABASE_DIR . '/migrations');
        $this->publishes([
            self::DATABASE_DIR . '/migrations' => database_path('migrations'),
        ],self::DATABASE_GROUPS);
    }

    private function registerEvents(): void
    {
        foreach (config('callmeaf-order.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(self::RESOURCES_DIR . '/views',self::VIEWS_NAMESPACE);
        $this->publishes([
            self::RESOURCES_DIR . '/views' => resource_path('views/vendor/callmeaf-order'),
        ],self::VIEWS_GROUP);

    }

    private function registerLang(): void
    {
        $langPathFromVendor = lang_path('vendor/callmeaf/order');
        if(is_dir($langPathFromVendor)) {
            $this->loadTranslationsFrom($langPathFromVendor,self::LANG_NAMESPACE);
        } else {
            $this->loadTranslationsFrom(self::LANG_DIR,self::LANG_NAMESPACE);
        }
        $this->publishes([
            self::LANG_DIR => $langPathFromVendor,
        ],self::LANG_GROUP);
    }
}
