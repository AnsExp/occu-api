<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

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
            'features' => ['nullable', 'array'],
            'features.*' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'periodicity.required' => 'La periodicidad es obligatoria.',
            'description.required' => 'La descripción es obligatoria.',
            'features.*.required' => 'Cada característica es obligatoria.',
        ];
    }
}
