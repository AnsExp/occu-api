<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class SpecialtyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('specialty');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('specialties', 'name')->ignore($id)],
            'price_base' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'price_base.required' => 'El precio base es obligatorio.',
            'price_base.numeric' => 'El precio base debe ser un número.',
            'price_base.min' => 'El precio base no puede ser negativo.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
        ];
    }
}
