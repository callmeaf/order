<?php

namespace Callmeaf\Order\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRemoveVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-order.form_request_authorizers.order'))->removeVoucher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'voucher_code' => ['string','max:255',Rule::exists(config('callmeaf-voucher.model'),'code')],
        ],filters: app(config("callmeaf-order.validations.order"))->removeVoucher());
    }

}
