<?php

namespace Callmeaf\Order\Services\V1;

use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Cart\Enums\CartType;
use Callmeaf\Order\Enums\OrderItemDiscountType;
use Callmeaf\Order\Enums\OrderItemType;
use Callmeaf\Order\Enums\OrderStatus;
use Callmeaf\Order\Enums\OrderType;
use Callmeaf\Order\Exceptions\UserHasNotDefaultAddressException;
use Callmeaf\Order\Models\Order;
use Callmeaf\Order\Models\OrderItem;
use Callmeaf\Order\Services\V1\Contracts\OrderServiceInterface;
use Callmeaf\User\Models\User;
use Callmeaf\User\Services\V1\UserService;
use Callmeaf\Variation\Models\Variation;
use Callmeaf\Variation\Services\V1\VariationService;
use Callmeaf\Voucher\Enums\VoucherType;
use Callmeaf\Voucher\Exceptions\VoucherCanNotApplyOrRemoveForNonPendingOrderException;
use Callmeaf\Voucher\Models\Voucher;
use Callmeaf\Voucher\Services\V1\VoucherService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderService extends BaseService implements OrderServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [],?string $searcher = null)
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData,$searcher);
        $this->query = app(config('callmeaf-order.model'))->query();
        $this->resource = config('callmeaf-order.model_resource');
        $this->resourceCollection = config('callmeaf-order.model_resource_collection');
        $this->defaultData = config('callmeaf-order.default_values');
        $this->searcher = config('callmeaf-order.searcher');
    }


    public function createOrder(array $data = [],?User $user = null,?array $events = []): OrderServiceInterface
    {
        $user = $user ?? authUser();
        if(is_null($user)) {
            // TODO: Create Order From Session
            return $this->createOrderFromGuestSession();
        }
        if($user->isSuperAdminOrAdmin()) {
            /**
             * @var UserService $userService
             */
            $userService = app(config('callmeaf-user.service'));
            $user = $userService->where(column: 'id',valueOrOperation: $data['user_id'])->first(columns: ['id'])->getModel();
            return $this->createOrderFromVariationsIds(variationsData: $data['variations'],user: $user,events: $events);
        }
        return $this->createOrderFromUserCart();
    }

    public function createOrderFromVariationsIds(array $variationsData,?User $user = null,?array $events = []): OrderServiceInterface
    {
        $variationsData = collect($variationsData);
        $user = $user ?? authUser();
        /**
         * @var VariationService $variationService
         */
        $variationService = app(config('callmeaf-variation.service'));
        $variations = $variationService->freshQuery()->where(column: 'id',valueOrOperation: $variationsData->pluck('id')->toArray())->all(orderBy: ['created_at','asc'])->getCollection();

        $orderData = [
            'user_id' => $user->id,
            'type' => OrderType::ONLINE,
            'total_price' => $variations->sum('realPrice'),
        ];

        if($variations->filter(fn($variation) => $variation->isPhysical())->count()) {
            $defaultAddress = $user->defaultAddress;
            if(is_null($defaultAddress)) {
                throw new UserHasNotDefaultAddressException();
            }
            $orderData['address_id'] = $defaultAddress->id;
        }

        $this->create(data: $orderData,events: $events);

        // set qty for each order items via variations
        $variations = $variations->map(function(Variation $variation) use ($variationsData) {
            $currentVariationInData = $variationsData->first(fn($item) => strval($item['id']) === strval($variation->id));

            $variation->qty = $currentVariationInData['qty'] ?? 1;
            return $variation;
        });
        /**
         * @var OrderItemService $orderItemService
         */
        $orderItemService = app(config('callmeaf-order-item.service'));
        $orderItemsData = collect([]);
        foreach ($variations as $variation) {
            $orderItemsData->push($orderItemService->mergeData(data: [
                'variation_id' => $variation->id,
                'type' => $variation->isPhysical() ? OrderItemType::DELIVERY : OrderItemType::ONLINE,
                'price' => $variation->realPrice,
                'qty' => $variation->qty,
            ]));
        }
        $this->model->items()->createMany(records: $orderItemsData);
        return $this;
    }

    public function createOrderFromUserCart(?User $user = null,CartType $cartType = CartType::CURRENT): OrderServiceInterface
    {
        $cart = $cartType === CartType::CURRENT ? $user->currentCart() : $user->futureCart();
        $variationsIds = $cart->items()->pluck('variation_id');

    }

    public function createOrderFromGuestSession(): OrderServiceInterface
    {
        // TODO: Implement createOrderFromGuestSession() method.
    }

    public function newRefCode(): ?string
    {
        $refCode = randomId(length: config('callmeaf-order.ref_code_length'),prefix: config('callmeaf-order.prefix_ref_code'));
        if(is_null($refCode)) {
            return null;
        }
        if($this->freshQuery()->where(column: 'ref_code',valueOrOperation: $refCode)->exists()) {
            return  $this->newRefCode();
        }
        return $refCode;
    }

    public function applyVoucher(string $voucherCode): OrderServiceInterface
    {
        /**
         * @var VoucherService $voucherService
         */
        $voucherService = app(config('callmeaf-voucher.service'));
        /**
         * @var Voucher $voucher
         */
        $voucher = $voucherService->where(column: 'code',valueOrOperation: $voucherCode)->first()->getModel();
        /**
         * @var Order $order
         */
        $order = $this->model;

        $voucher->canBeUsedForOrder(order: $order,user: $order->user);

        /**
         * @var OrderItem[] $orderItems
         */
        $orderItems = $order->items;
        foreach ($orderItems as $orderItem) {
            $order->discounts()->create([
                'order_item_id' => $orderItem->id,
                'voucher_id' => $voucher->id,
                'type' => OrderItemDiscountType::VOUCHER,
                'discount_price' => $voucher->discount_price,
                'is_fixed' => $voucher->type === VoucherType::IS_FIXED,
            ]);
        }

        $this->freshModel();

        return $this;
    }

    public function removeVoucher(string $voucherCode): OrderServiceInterface
    {
        /**
         * @var Order $order
         */
        $order = $this->model;
        if($order->status !== OrderStatus::PENDING) {
            throw new VoucherCanNotApplyOrRemoveForNonPendingOrderException();
        }
        /**
         * @var VoucherService $voucherService
         */
        $voucherService = app(config('callmeaf-voucher.service'));
        /**
         * @var Voucher $voucher
         */
        $voucher = $voucherService->where(column: 'code',valueOrOperation: $voucherCode)->first(columns: ['id','code'])->getModel();
        $order->discounts()->where('voucher_id',$voucher->id)->delete();

        return $this;
    }
}
