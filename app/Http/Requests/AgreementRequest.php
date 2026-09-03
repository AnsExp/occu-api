<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class AgreementRequest extends FormRequest
{
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
            'institution' => ['required', 'string', 'max:255'],
            'discount_type' => ['required', 'string', 'in:percentage,fixed'],
            'discount_amount' => ['required', 'numeric', 'min:0', $this->input('discount_type') === 'percentage' ? 'max:100' : ''],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'array'],
            'requirements.*' => ['required', 'exists:specialties,id'],
        ];
    }

    public function messages()
    {
        return [
            'institution.required' => 'The institution field is required.',
            'discount_type.required' => 'The discount type field is required.',
            'discount_type.in' => 'The selected discount type is invalid.',
            'discount_amount.required' => 'The discount amount field is required.',
            'discount_amount.numeric' => 'The discount amount must be a number.',
            'discount_amount.min' => 'The discount amount must be at least 0.',
            'discount_amount.max' => 'The discount amount must not exceed 100 for percentage discounts.',
            'description.required' => 'The description field is required.',
        ];
    }
}
