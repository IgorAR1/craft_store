<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'string',
            'price' => 'required|integer',
            'img_url' => 'required|url',
            'quantity' => 'integer',
            'color' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'int|exists:categories,id'
        ];
    }
}
