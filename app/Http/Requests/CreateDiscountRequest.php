<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Если у вас есть система ролей и прав, можно здесь проверять авторизацию пользователя.
        return true; // Для примера, мы разрешаем всем.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'nullable|string|max:255|unique:discounts,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'uses' => 'nullable|integer|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'max_uses_user' => 'nullable|integer|min:0',
            'type' => 'required|integer|in:1,2,3',
            'discount_amount' => 'required|integer|min:1',
            'is_fixed' => 'nullable|boolean',
            'starts_at' => 'required|date|after_or_equal:today',
            'expires_at' => 'required|date|after:starts_at',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'code.unique' => 'Этот код скидки уже используется.',
            'name.required' => 'Название скидки обязательно.',
            'type.required' => 'Необходимо указать тип скидки.',
            'discount_amount.required' => 'Необходимо указать сумму или процент скидки.',
            'starts_at.after_or_equal' => 'Дата начала должна быть сегодня или позже.',
            'expires_at.after' => 'Дата окончания должна быть позже, чем дата начала.',
        ];
    }
}
