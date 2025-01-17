<?php

namespace Callmeaf\Order\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Order\Events\OrderDestroyed;
use Callmeaf\Order\Events\OrderForceDestroyed;
use Callmeaf\Order\Events\OrderIndexed;
use Callmeaf\Order\Events\OrderRestored;
use Callmeaf\Order\Events\OrderShowed;
use Callmeaf\Order\Events\OrderStatusUpdated;
use Callmeaf\Order\Events\OrderStored;
use Callmeaf\Order\Events\OrderTrashed;
use Callmeaf\Order\Events\OrderUpdated;
use Callmeaf\Order\Http\Requests\V1\Api\OrderApplyVoucherRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderDestroyRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderForceDestroyRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderIndexRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderRemoveVoucherRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderRestoreRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderShowRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderStatusUpdateRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderStoreRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderTrashedIndexRequest;
use Callmeaf\Order\Http\Requests\V1\Api\OrderUpdateRequest;
use Callmeaf\Order\Models\Order;
use Callmeaf\Order\Services\V1\OrderService;
use Callmeaf\Order\Utilities\V1\Api\Order\OrderResources;

class OrderController extends ApiController
{
    protected OrderService $orderService;
    protected OrderResources $orderResources;
    public function __construct()
    {
        $this->orderService = app(config('callmeaf-order.service'));
        $this->orderResources = app(config('callmeaf-order.resources.order'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-order.middlewares.order'))();
    }

    public function index(OrderIndexRequest $request)
    {
        try {
            $resources = $this->orderResources->index();
            $orders = $this->orderService->all(
                relations: $resources->relations(),
                columns: $resources->columns(),
                filters: $request->validated(),
            )->getCollection(asResourceCollection: true,asResponseData: true,attributes: $resources->attributes(),events: [
                OrderIndexed::class,
            ]);
            return apiResponse([
                'orders' => $orders,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function store(OrderStoreRequest $request)
    {
        try {
            $resources = $this->orderResources->store();
            $order = $this->orderService->createOrder(data: $request->validated(),events: [
                OrderStored::class
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_created', [
                'title' => $order->responseTitles(ResponseTitle::STORE),
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function show(OrderShowRequest $request,Order $order)
    {
        try {
            $resources = $this->orderResources->show();
            $order = $this->orderService->setModel($order)->getModel(
                asResource: true,
                attributes: $resources->attributes(),
                relations: $resources->relations(),
                events: [
                    OrderShowed::class,
                ],
            );
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function update(OrderUpdateRequest $request,Order $order)
    {
        try {
            // TODO: REMOVE IF NOT USED
            $resources = $this->orderResources->update();
            $order = $this->orderService->setModel($order)->update(data: $request->validated(),events: [
                OrderUpdated::class,
            ])->syncCats(catIds: $request->get('cat_ids'))->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $order->responseTitles(ResponseTitle::UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function statusUpdate(OrderStatusUpdateRequest $request,Order $order)
    {
        try {
            $resources = $this->orderResources->statusUpdate();
            $order = $this->orderService->setModel($order)->update([
                'status' => $request->get('status'),
            ],events: [
                OrderStatusUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $order->responseTitles(ResponseTitle::STATUS_UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function destroy(OrderDestroyRequest $request,Order $order)
    {
        try {
            // TODO: REMOVE IF NOT USED
            $resources = $this->orderResources->destroy();
            $order = $this->orderService->setModel($order)->delete(events: [
                OrderDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_deleted', [
                'title' =>  $order->responseTitles(ResponseTitle::DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }


    public function restore(OrderRestoreRequest $request,string|int $id)
    {
        try {
            // TODO: REMOVE IF NOT USED
            $resources = $this->orderResources->restore();
            $order = $this->orderService->restore(id: $id,idColumn: $resources->idColumn(),events: [
                OrderRestored::class
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_restored',[
                'title' =>  $order->responseTitles(ResponseTitle::RESTORE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function trashed(OrderTrashedIndexRequest $request)
    {
        try {
            // TODO: REMOVE IF NOT USED
            $resources = $this->orderResources->trashed();
            $orders = $this->orderService->onlyTrashed()->all(
                relations: $resources->relations(),
                columns: $resources->columns(),
                filters: $request->validated(),
            )->getCollection(asResourceCollection: true,asResponseData: true,attributes: $resources->attributes(),events: [
                OrderTrashed::class,
            ]);
            return apiResponse([
                'orders' => $orders,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function forceDestroy(OrderForceDestroyRequest $request,string|int $id)
    {
        try {
            // TODO: REMOVE IF NOT USED
            $resources = $this->orderResources->forceDestroy();
            $order = $this->orderService->forceDelete(id: $id,idColumn: $resources->idColumn(),columns: $resources->columns(),events: [
                OrderForceDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-base::v1.successful_force_destroyed',[
                'title' =>  $order->responseTitles(ResponseTitle::FORCE_DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function applyVoucher(OrderApplyVoucherRequest $request,Order $order)
    {
        try {
            $resources = $this->orderResources->applyVoucher();
            $order = $this->orderService->setModel($order)->applyVoucher(voucherCode: $request->get('voucher_code'))->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-order::v1.voucher_applied_successfully'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function removeVoucher(OrderRemoveVoucherRequest $request,Order $order)
    {
        try {
            $resources = $this->orderResources->removeVoucher();
            $order = $this->orderService->setModel($order)->removeVoucher(voucherCode: $request->get('voucher_code'))->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'order' => $order,
            ],__('callmeaf-order::v1.voucher_remove_successfully'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
