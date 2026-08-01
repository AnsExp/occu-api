<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'timezone' => ['required', 'string'],
            'specialty.id' => ['required', 'exists:specialties,id'],
            'medical_date.id' => ['required', 'exists:medical_dates,id'],
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
            'specialty.id.exists' => __('validation.exists', ['attribute' => 'especialidad']),
            'specialty.id.required' => __('validation.required', ['attribute' => 'especialidad']),
            'medical_date.id.exists' => __('validation.exists', ['attribute' => 'cita médica']),
            'medical_date.id.required' => __('validation.required', ['attribute' => 'cita médica']),
            'medical_exam.array' => __('validation.array', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.required' => __('validation.required', ['attribute' => __('audiology.medical_exam')]),
            'medical_exam.hearing.array' => __('validation.array', ['attribute' => __('audiology.hearing')]),
            'medical_exam.hearing.required' => __('validation.required', ['attribute' => __('audiology.hearing')]),
            'medical_exam.speech_whisper.array' => __('validation.array', ['attribute' => __('audiology.speech_whisper_test')]),
            'medical_exam.speech_whisper.required' => __('validation.required', ['attribute' => __('audiology.speech_whisper_test')]),
        ];
    }
}
