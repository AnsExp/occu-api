<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class AudiologyRequest extends FormRequest
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
            'timezone' => ['nullable', 'string'],
            'medical_exam' => ['required', 'array'],
            'medical_exam.hearing' => ['required', 'array'],
            'medical_exam.hearing.*' => ['required', 'string'],
            'medical_exam.speech_whisper' => ['required', 'array'],
            'medical_exam.speech_whisper.*' => ['required', 'string', 'in:normal,whisper'],
        ];
    }

    public function messages()
    {
        return [
            'timezone.string' => __('validation.string', ['attribute' => 'zona horaria']),
            'timezone.required' => __('validation.required', ['attribute' => 'zona horaria']),
            'medical_exam.array' => __('validation.array', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.required' => __('validation.required', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.hearing.array' => __('validation.array', ['attribute' => __('audiology.hearing')]),
            'medical_exam.hearing.required' => __('validation.required', ['attribute' => __('audiology.hearing')]),
            'medical_exam.speech_whisper.array' => __('validation.array', ['attribute' => __('audiology.speech_whisper_test')]),
            'medical_exam.speech_whisper.required' => __('validation.required', ['attribute' => __('audiology.speech_whisper_test')]),
        ];
    }
}
