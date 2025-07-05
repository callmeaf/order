<?php

namespace Callmeaf\Order\App\Http\Requests\Api\V1;

use Callmeaf\Address\App\Repo\Contracts\AddressRepoInterface;
use Callmeaf\Order\App\Enums\OrderStatus;
use Callmeaf\Order\App\Enums\OrderType;
use Callmeaf\User\App\Repo\Contracts\UserRepoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $addressId = $this->get('address_id');

        if(! $addressId) {
            return true;
        }
        return $this->user()->addresses()->active()->whereKey($this->get('address_id'))->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(UserRepoInterface $userRepo,AddressRepoInterface $addressRepo): array
    {
        return [
            'status' => ['required',new Enum(OrderStatus::class)],
            'type' => ['required',new Enum(OrderType::class)],
            'user_identifier' => ['required',Rule::exists($userRepo->getTable(),$userRepo->getModel()->identifierKey())],
            'address_id' => ['required',Rule::exists($addressRepo->getTable(),$addressRepo->getModel()->getKeyName())]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => OrderStatus::PENDING->value,
            'user_identifier' => $this->user()->identifier(),
        ]);

        $this->mergeIfMissing([
            'type' => OrderType::PERSONAL->value,
        ]);
    }
}
