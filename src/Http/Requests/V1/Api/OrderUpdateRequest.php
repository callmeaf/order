<?php

namespace Callmeaf\Order\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-order.form_request_authorizers.order'))->update();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'voucher_code' => ['string',Rule::exists(config('callmeaf-voucher.model'),'code')],
            'variations_ids' => ['array'],
            'variations_ids.*' => [Rule::exists(config('callmeaf-variation.model'),'id')],
        ],filters: app(config("callmeaf-order.validations.order"))->update());
    }

}
