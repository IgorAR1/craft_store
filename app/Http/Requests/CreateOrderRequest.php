<?php

namespace App\Http\Requests;

use App\Enums\ShipmentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deliveryAddress' => 'required|array',
                'deliveryAddress.country' => 'required|string',
                'deliveryAddress.region' => 'required|string',
                'deliveryAddress.city' => 'required|string',
                'deliveryAddress.district' => 'required|string',
                'deliveryAddress.street' => 'required|string',
                'deliveryAddress.building' => 'required|string',
                'deliveryAddress.floor' => 'sometimes|required|string',
                'deliveryAddress.apartment_number' => 'sometimes|required|string',

            'products'=> 'required|array',
                'products.*.product_id' => 'required|uuid|exists:products,id',
                'products.*.quantity' => 'required|integer',
            'deliveryType' => ['required','string',Rule::in(['self','courier'])],
            'payment' => 'array',
                'payment.paymentType' => 'string',
                'payment.paymentId' => 'int',
        ];
    }
}
