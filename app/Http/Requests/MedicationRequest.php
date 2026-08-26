<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('attributes.name')]),
            'name.string' => __('validation.string', ['attribute' => __('attributes.name')]),
            'price.required' => __('validation.required', ['attribute' => __('attributes.price')]),
            'price.numeric' => __('validation.numeric', ['attribute' => __('attributes.price')]),
        ];
    }
}
