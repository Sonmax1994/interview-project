<?php

namespace App\Http\Requests\FruitItem;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\FruitItemServices;

class CreateFruitItemRequest extends FormRequest
{
    public function __construct()
    {
        $this->fruitItemServices = new FruitItemServices;
    }

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
        $arrValueUnitItem = $this->fruitItemServices->getArrValueUnitItem();
        return [
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:fruit_categories,id'],
            'unit'        => ['required', 'integer', 'in:' . implode(", ",$arrValueUnitItem)],
            'price'       => ['required', 'string'],
        ];
    }

    
}
