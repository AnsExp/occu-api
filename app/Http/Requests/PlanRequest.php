<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'periodicity' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'items' => ['string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del plan es obligatorio.',
            'name.string' => 'El nombre del plan debe ser una cadena de texto.',
            'name.max' => 'El nombre del plan no debe exceder los 255 caracteres.',
            'price.required' => 'El precio del plan es obligatorio.',
            'price.string' => 'El precio del plan debe ser una cadena de texto.',
            'price.max' => 'El precio del plan no debe exceder los 255 caracteres.',
            'periodicity.required' => 'La periodicidad del plan es obligatoria.',
            'periodicity.string' => 'La periodicidad del plan debe ser una cadena de texto.',
            'periodicity.max' => 'La periodicidad del plan no debe exceder los 255 caracteres.',
            'description.required' => 'La descripción del plan es obligatoria.',
            'description.string' => 'La descripción del plan debe ser una cadena de texto.',
            'items.string' => 'Los ítems del plan deben ser una cadena de texto.',
        ];
    }
}
