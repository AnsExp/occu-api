<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

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
            'date' => ['required', 'date'],
            'type' => ['nullable', 'in:normal,occupational'],
            'doctor.id' => ['required', 'exists:doctors,id'],
            'specialty.id' => ['nullable', 'exists:specialties,id'],
            'person.id_card' => ['required', 'exists:personal_data,id_card'],
            'timezone' => ['required', 'string'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
            'relationship' => ['nullable', 'array'],
            'relationship.*.date' => ['required', 'date'],
            'relationship.*.type' => ['nullable', 'in:normal,occupational'],
            'relationship.*.doctor.id' => ['required', 'exists:doctors,id'],
            'relationship.*.specialty.id' => ['nullable', 'exists:specialties,id'],
            'relationship.*.person.id_card' => ['required', 'exists:personal_data,id_card'],
        ];
    }

    public function messages()
    {
        return [
            'type.required' => __('validation.required', ['attribute' => __('attributes.type')]),
            'type.in' => __('validation.in', ['attribute' => __('attributes.type')]),
            'doctor.id.required' => __('validation.required', ['attribute' => __('attributes.responsible_doctor')]),
            'doctor.id.exists' => __('validation.exists', ['attribute' => __('attributes.responsible_doctor')]),
            'person.id_card.required' => __('validation.required', ['attribute' => __('attributes.patient')]),
            'person.id_card.exists' => __('validation.exists', ['attribute' => __('attributes.patient')]),
            'specialty.id.required' => __('validation.required', ['attribute' => __('attributes.specialty')]),
            'specialty.id.string' => __('validation.string', ['attribute' => __('attributes.specialty')]),
            'specialty.id.exists' => __('validation.exists', ['attribute' => __('attributes.specialty')]),
            'date.required' => __('validation.required', ['attribute' => __('attributes.date')]),
            'date.date' => __('validation.date', ['attribute' => __('attributes.date')]),
            'metadata.array' => __('validation.array', ['attribute' => __('attributes.metadata')]),
            'metadata.*.key.required' => __('validation.required', ['attribute' => __('attributes.metadata_key')]),
            'metadata.*.key.string' => __('validation.string', ['attribute' => __('attributes.metadata_key')]),
            'metadata.*.value.required' => __('validation.required', ['attribute' => __('attributes.metadata_value')]),
            'metadata.*.value.string' => __('validation.string', ['attribute' => __('attributes.metadata_value')]),
            'relationship.array' => __('validation.array', ['attribute' => __('attributes.relationship')]),
            'relationship.*.date.required' => __('validation.required', ['attribute' => __('attributes.relationship_date')]),
            'relationship.*.date.date' => __('validation.date', ['attribute' => __('attributes.relationship_date')]),
            'relationship.*.doctor.id.required' => __('validation.required', ['attribute' => __('attributes.relationship_doctor')]),
            'relationship.*.doctor.id.exists' => __('validation.exists', ['attribute' => __('attributes.relationship_doctor')]),
            'relationship.*.specialty.id.required' => __('validation.required', ['attribute' => __('attributes.relationship_specialty')]),
            'relationship.*.specialty.id.exists' => __('validation.exists', ['attribute' => __('attributes.relationship_specialty')]),
        ];
    }
}
