<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if ($this->has('id_card')) {
            $this->merge([
                'id_card_hash' => occu_hash($this->input('id_card')),
            ]);
        }
        if ($this->has('email')) {
            $this->merge([
                'email_hash' => occu_hash($this->input('email')),
            ]);
        }
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'is_occupational_doctor' => ['required', 'boolean'],
            'email_hash' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'id_card' => ['required', 'string'],
            'id_card_hash' => ['required', 'string'],
            'id_card_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'specialty.id' => ['required', 'exists:specialties,id'],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string'],
            'metadata.*.value' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'doctor.id.required' => __('validation.required', ['attribute' => __('attributes.responsible_doctor')]),
            'doctor.id.numeric' => __('validation.numeric', ['attribute' => __('attributes.responsible_doctor')]),
            'doctor.id.exists' => __('validation.exists', ['attribute' => __('attributes.responsible_doctor')]),
            'order.order_number.required' => __('validation.required', ['attribute' => __('attributes.order_number')]),
            'order.order_number.numeric' => __('validation.numeric', ['attribute' => __('attributes.order_number')]),
            'order.order_number.exists' => __('validation.exists', ['attribute' => __('attributes.order_number')]),
            'medical_exam.array' => __('validation.array', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.required' => __('validation.required', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.hearing.array' => __('validation.array', ['attribute' => __('audiology.hearing')]),
            'medical_exam.hearing.required' => __('validation.required', ['attribute' => __('audiology.hearing')]),
            'medical_exam.speech_whisper.array' => __('validation.array', ['attribute' => __('audiology.speech_whisper_test')]),
            'medical_exam.speech_whisper.required' => __('validation.required', ['attribute' => __('audiology.speech_whisper_test')]),
        ];
    }
}
