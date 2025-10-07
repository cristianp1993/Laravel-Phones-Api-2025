<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:100'],
            'slug'        => ['required','string','alpha_dash:ascii','max:255','unique:categories,slug'],
            'description' => ['nullable','string'],
            'estado'      => ['sometimes','boolean'],
            'position'    => ['sometimes','integer','min:0','max:65535'], 
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.unique'   => 'El slug ya existe en otra categoría.',
            'slug.alpha_dash' => 'El slug solo puede tener letras, números, guiones y guion bajo.',
        ];
    }
}
