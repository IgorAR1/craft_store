<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveFromCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products'=> 'required|array:uuid|exists:products,id',
            'products.*.product_ids' => 'required|uuid|exists:products,id',
            'products.*.quantity' => 'required|uuid|exists:products,id'
        ];
    }
}
