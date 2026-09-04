<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class RescheduleMedicalDateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'doctor.id' => ['required', 'exists:doctors,id'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => __('validation.required', ['attribute' => __('attributes.date')]),
            'date.date' => __('validation.date', ['attribute' => __('attributes.date')]),
            'doctor.id.required' => __('validation.required', ['attribute' => __('attributes.responsible_doctor')]),
            'doctor.id.exists' => __('validation.exists', ['attribute' => __('attributes.responsible_doctor')]),
        ];
    }
}
