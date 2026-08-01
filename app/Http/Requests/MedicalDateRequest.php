<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MedicalDateRequest extends FormRequest
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
            'timezone' => ['required', 'string'],
            'specialty.id' => ['required', 'exists:specialties,id'],
            'doctor.id' => ['required', 'exists:doctors,id'],
            'person.id' => ['required', 'exists:people,id'],
            'date' => ['required', 'date'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'timezone.required' => __('validation.required', ['attribute' => __('attributes.timezone')]),
            'timezone.string' => __('validation.string', ['attribute' => __('attributes.timezone')]),
            'doctor.id.required' => __('validation.required', ['attribute' => __('attributes.responsible_doctor')]),
            'doctor.id.exists' => __('validation.exists', ['attribute' => __('attributes.responsible_doctor')]),
            'person.id.required' => __('validation.required', ['attribute' => __('attributes.patient')]),
            'person.id.exists' => __('validation.exists', ['attribute' => __('attributes.patient')]),
            'specialty.id.required' => __('validation.required', ['attribute' => __('attributes.specialty')]),
            'specialty.id.string' => __('validation.string', ['attribute' => __('attributes.specialty')]),
            'specialty.id.exists' => __('validation.exists', ['attribute' => __('attributes.specialty')]),
            'date.required' => __('validation.required', ['attribute' => __('attributes.date')]),
            'date.date' => __('validation.date', ['attribute' => __('attributes.date')]),
        ];
    }
}
