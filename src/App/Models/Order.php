<?php

namespace Callmeaf\Order\App\Models;

use Callmeaf\Address\App\Repo\Contracts\AddressRepoInterface;
use Callmeaf\Base\App\Models\BaseModel;
use Callmeaf\Base\App\Traits\Model\HasDate;
use Callmeaf\Base\App\Traits\Model\HasStatus;
use Callmeaf\Base\App\Traits\Model\HasType;
use Callmeaf\OrderItem\App\Repo\Contracts\OrderItemRepoInterface;
use Callmeaf\User\App\Repo\Contracts\UserRepoInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
     use SoftDeletes;
    use HasStatus,HasType,HasDate;

    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'status',
        'type',
        'user_identifier',
        'address_id',
        'total_price',
        'total_cost',
        'total_profit',
    ];

    public static function configKey(): string
    {
        return 'callmeaf-order';
    }

    protected function casts(): array
    {
        return [
            ...(self::config()['enums'] ?? []),
        ];
    }

    public function items(): HasMany
    {
        /**
         * @var OrderItemRepoInterface $orderItemRepo
         */
        $orderItemRepo = app(OrderItemRepoInterface::class);
        return $this->hasMany($orderItemRepo->getModel()::class,'order_code',$this->getKeyName());
    }

    public function address(): BelongsTo
    {
        /**
         * @var AddressRepoInterface $addressRepo
         */
        $addressRepo = app(AddressRepoInterface::class);
        return $this->belongsTo($addressRepo->getModel()::class,'address_id',$addressRepo->getModel()->getKeyName());
    }

    public function user(): BelongsTo
    {
        /**
         * @var UserRepoInterface $userRepo
         */
        $userRepo = app(UserRepoInterface::class);
        return $this->belongsTo($userRepo->getModel()::class,'user_identifier',$userRepo->getModel()->identifierKey());
    }

    public function variants(): array
    {
        $data = [];

        foreach ($this->items()->with(['variant'])->get() as $item) {
            $variant = $item->variant;
            $variant->qty = $item->qty;
            $data[] = $variant;
        }

        return $data;
    }
}
