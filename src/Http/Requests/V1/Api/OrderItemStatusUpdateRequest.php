<?php

namespace Callmeaf\Order\Http\Requests\V1\Api;

use Callmeaf\Order\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderItemStatusUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-order-item.form_request_authorizers.order_item'))->statusUpdate();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'status' => [new Enum(OrderStatus::class)],
        ],filters: app(config("callmeaf-order-item.validations.order_item"))->statusUpdate());
    }

}
