<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePhoneRequest extends FormRequest
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
            'number'       => ['required','string','min:7','max:20','regex:/^[0-9+\s\-\(\)]+$/','unique:phones,number'],
            'country_code' => ['nullable','string','max:5'],
            'area_code'    => ['nullable','string','max:10'],
            'type'         => ['required','string', Rule::in(['mobile','home','work','other'])],
            'is_primary'   => ['boolean'],
            'extension'    => ['nullable','string','max:10'],
            'notes'        => ['nullable','string'],
            'category_id'  => ['nullable','integer','exists:categories,id'],
            'barcode'      => ['nullable','string','max:255'],
        ];
    }
}
