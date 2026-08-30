<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class DoctorRequest extends PersonalDataRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['is_occupational_doctor' => $this->has('is_occupational_doctor')]);
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...$this->commonRules(),
            'is_occupational_doctor' => ['required', 'boolean'],
            'specialty.id' => ['required', 'exists:specialties,id'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            ...$this->commonMessages(),
            'is_occupational_doctor.required' => __('validation.required', ['attribute' => __('attributes.is_occupational_doctor')]),
            'is_occupational_doctor.boolean' => __('validation.boolean', ['attribute' => __('attributes.is_occupational_doctor')]),
            'specialty.id.required' => __('validation.required', ['attribute' => __('attributes.specialty')]),
            'specialty.id.exists' => __('validation.exists', ['attribute' => __('attributes.specialty')]),
        ];
    }
}
