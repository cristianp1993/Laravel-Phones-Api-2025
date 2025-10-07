<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id; 

        return [
            'name'        => ['sometimes','string','max:100'],
            'slug'        => [
                'sometimes','string','alpha_dash:ascii','max:255',
                Rule::unique('categories','slug')->ignore($categoryId)
            ],
            'description' => ['sometimes','nullable','string'],
            'estado'      => ['sometimes','boolean'],
            'position'    => ['sometimes','integer','min:0','max:65535'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'El slug ya existe en otra categoría.',
        ];
    }
}
