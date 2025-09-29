<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool { return true; }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $phoneId = $this->route('phone')?->id; // por route model binding

        return [
            'number'       => ['sometimes','string','min:7','max:20','regex:/^[0-9+\s\-\(\)]+$/', Rule::unique('phones','number')->ignore($phoneId)],
            'country_code' => ['sometimes','string','max:5'],
            'area_code'    => ['sometimes','string','max:10'],
            'type'         => ['sometimes','string', Rule::in(['mobile','home','work','other'])],
            'is_primary'   => ['sometimes','boolean'],
            'extension'    => ['sometimes','nullable','string','max:10'],
            'notes'        => ['sometimes','nullable','string'],
        ];
    }
}
