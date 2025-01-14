<?php

namespace Callmeaf\Order\Http\Requests\V1\Api;

use Callmeaf\Order\Enums\OrderItemStatus;
use Callmeaf\Order\Enums\OrderItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-order-item.form_request_authorizers.order_item'))->update();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'status' => [new Enum(OrderItemStatus::class)],
            'type' => [new Enum(OrderItemType::class)],
            'qty' => ['integer'],
        ],filters: app(config("callmeaf-order-item.validations.order_item"))->update());
    }

}
