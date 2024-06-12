<?php

namespace App\Http\Requests\FruitCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFruitCategoryRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255'],
            'descriptions' => ['nullable', 'string', 'max:500'],
        ];
    }
}