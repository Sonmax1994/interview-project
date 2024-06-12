<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function __construct()
    {
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
        return [
            'items'       => ['array', 'required'],
            'items.*'    => ['required', 'exists:fruit_items,id'],
            'quantity'    => ['array', 'required'],
            'quantity.*' => ['numeric', 'required'],
        ];
    }

}
