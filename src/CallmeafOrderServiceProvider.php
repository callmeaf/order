<?php

namespace Callmeaf\Order;

use Callmeaf\Base\CallmeafServiceProvider;
use Callmeaf\Base\Contracts\ServiceProvider\HasConfig;
use Callmeaf\Base\Contracts\ServiceProvider\HasEvent;
use Callmeaf\Base\Contracts\ServiceProvider\HasLang;
use Callmeaf\Base\Contracts\ServiceProvider\HasMigration;
use Callmeaf\Base\Contracts\ServiceProvider\HasRepo;
use Callmeaf\Base\Contracts\ServiceProvider\HasRoute;
use Callmeaf\Base\Contracts\ServiceProvider\HasView;
use Callmeaf\Order\App\Repo\Contracts\OrderRepoInterface;

class CallmeafOrderServiceProvider extends CallmeafServiceProvider implements HasRepo, HasEvent, HasRoute, HasMigration, HasConfig, HasLang,HasView
{
    protected function serviceKey(): string
    {
        return 'order';
    }

    public function repo(): string
    {
        return OrderRepoInterface::class;
    }
}
