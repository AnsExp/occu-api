<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'birth_date' => ['nullable', 'date'],
            'id_card' => ['required', 'string', 'max:255'],
            'id_card_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'email' => ['required', 'email', 'max:255'],
            'agreement.id' => ['nullable', 'exists:agreements,id'],
            'phone' => ['nullable', 'string', 'max:255'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string', 'max:255'],
            'metadata.*.value' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('attributes.first_name')]),
            'first_name.string' => __('validation.string', ['attribute' => __('attributes.first_name')]),
            'first_name.max' => __('validation.max.string', ['attribute' => __('attributes.first_name'), 'max' => 255]),
            'last_name.required' => __('validation.required', ['attribute' => __('attributes.last_name')]),
            'last_name.string' => __('validation.string', ['attribute' => __('attributes.last_name')]),
            'last_name.max' => __('validation.max.string', ['attribute' => __('attributes.last_name'), 'max' => 255]),
            'nationality.required' => __('validation.required', ['attribute' => __('attributes.nationality')]),
            'nationality.string' => __('validation.string', ['attribute' => __('attributes.nationality')]),
            'nationality.max' => __('validation.max.string', ['attribute' => __('attributes.nationality'), 'max' => 255]),
            'gender.required' => __('validation.required', ['attribute' => __('attributes.gender')]),
            'gender.string' => __('validation.string', ['attribute' => __('attributes.gender')]),
            'gender.max' => __('validation.max.string', ['attribute' => __('attributes.gender'), 'max' => 255]),
            'birth_date.required' => __('validation.required', ['attribute' => __('attributes.birth_date')]),
            'birth_date.date' => __('validation.date', ['attribute' => __('attributes.birth_date')]),
            'id_card.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'id_card.max' => __('validation.max.string', ['attribute' => __('attributes.id_card'), 'max' => 255]),
            'id_card.string' => __('validation.string', ['attribute' => __('attributes.id_card')]),
            'id_card_hash.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'id_card_hash.max' => __('validation.max.string', ['attribute' => __('attributes.id_card'), 'max' => 255]),
            'id_card_file.required' => __('validation.required', ['attribute' => __('attributes.id_card_file')]),
            'id_card_file.file' => __('validation.file', ['attribute' => __('attributes.id_card_file')]),
            'id_card_file.mimes' => __('validation.mimes', ['attribute' => __('attributes.id_card_file'), 'values' => 'pdf']),
            'id_card_file.max' => __('validation.max.file', ['attribute' => __('attributes.id_card_file'), 'max' => 2048]),
            'email.email' => __('validation.email', ['attribute' => __('attributes.email')]),
            'email_hash.max' => __('validation.max.string', ['attribute' => __('attributes.email'), 'max' => 255]),
        ];
    }
}
