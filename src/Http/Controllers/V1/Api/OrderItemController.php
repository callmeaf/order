<?php

namespace Callmeaf\Order\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Order\Events\OrderItemDestroyed;
use Callmeaf\Order\Events\OrderItemStatusUpdated;
use Callmeaf\Order\Events\OrderItemUpdated;
use Callmeaf\Order\Http\Requests\V1\Api\OrderItemDestroyRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderItemStatusUpdateRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderItemUpdateRequest;
use Callmeaf\Order\Models\OrderItem;
use Callmeaf\Order\Services\V1\OrderItemService;
use Callmeaf\Order\Utilities\V1\Api\OrderItem\OrderItemResources;

class OrderItemController extends ApiController
{
    protected OrderItemService $orderItemService;
    protected OrderItemResources $orderItemResources;
    public function __construct()
    {
        $this->orderItemService = app(config('callmeaf-order-item.service'));
        $this->orderItemResources = app(config('callmeaf-order-item.resources.order_item'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-order-item.middlewares.order_item'))();
    }

    public function update(OrderItemUpdateRequest $request,OrderItem $orderItem)
    {
        try {
            $resources = $this->orderItemResources->update();
            $orderItem = $this->orderItemService->setModel($orderItem)->update(data: $request->validated(),events: [
                OrderItemUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order_item' => $orderItem,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $orderItem->responseTitles(ResponseTitle::UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function statusUpdate(OrderItemStatusUpdateRequest $request,OrderItem $orderItem)
    {
        try {
            $resources = $this->orderItemResources->statusUpdate();
            $orderItem = $this->orderItemService->setModel($orderItem)->update([
                'status' => $request->get('status'),
            ],events: [
                OrderItemStatusUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order_item' => $orderItem,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $orderItem->responseTitles(ResponseTitle::STATUS_UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function destroy(OrderItemDestroyRequest $request,OrderItem $orderItem)
    {
        try {
            $resources = $this->orderItemResources->destroy();
            $orderItem = $this->orderItemService->setModel($orderItem)->delete(events: [
                OrderItemDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order_item' => $orderItem,
            ],__('callmeaf-base::v1.successful_deleted', [
                'title' =>  $orderItem->responseTitles(ResponseTitle::DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

}
