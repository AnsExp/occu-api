<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class PersonalDataRequest extends FormRequest
{
    protected function commonRules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'id_card' => ['required', 'string'],
            'id_card_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'nationality' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
        ];
    }

    protected function commonMessages(): array
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('attributes.first_name')]),
            'first_name.string' => __('validation.string', ['attribute' => __('attributes.first_name')]),
            'last_name.required' => __('validation.required', ['attribute' => __('attributes.last_name')]),
            'last_name.string' => __('validation.string', ['attribute' => __('attributes.last_name')]),
            'email.required' => __('validation.required', ['attribute' => __('attributes.email')]),
            'email.email' => __('validation.email', ['attribute' => __('attributes.email')]),
            'phone.string' => __('validation.string', ['attribute' => __('attributes.phone')]),
            'id_card.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'id_card.string' => __('validation.string', ['attribute' => __('attributes.id_card')]),
            'id_card_file.file' => __('validation.file', ['attribute' => __('attributes.id_card_file')]),
            'id_card_file.mimes' => __('validation.mimes', ['attribute' => __('attributes.id_card_file'), 'values' => 'pdf']),
            'id_card_file.max' => __('validation.max.file', ['attribute' => __('attributes.id_card_file'), 'max' => 2048]),
            'nationality.string' => __('validation.string', ['attribute' => __('attributes.nationality')]),
            'gender.string' => __('validation.string', ['attribute' => __('attributes.gender')]),
        ];
    }
}
