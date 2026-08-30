<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class PatientRequest extends PersonalDataRequest
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
            ...$this->commonRules(),
            'agreement.id' => ['nullable', 'exists:agreements,id'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string', 'max:255'],
            'metadata.*.value' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            ...$this->commonMessages(),
            'agreement.id.exists' => __('validation.exists', ['attribute' => __('attributes.agreement')]),
            'metadata.*.key.required' => __('validation.required', ['attribute' => __('attributes.metadata_key')]),
            'metadata.*.key.string' => __('validation.string', ['attribute' => __('attributes.metadata_key')]),
            'metadata.*.key.max' => __('validation.max.string', ['attribute' => __('attributes.metadata_key'), 'max' => 255]),
            'metadata.*.value.required' => __('validation.required', ['attribute' => __('attributes.metadata_value')]),
            'metadata.*.value.string' => __('validation.string', ['attribute' => __('attributes.metadata_value')]),
            'metadata.*.value.max' => __('validation.max.string', ['attribute' => __('attributes.metadata_value'), 'max' => 255]),
        ];
    }
}
