<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OccupationalMedicalDateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'person.id' => ['required', 'exists:personal_data,id'],
            'doctor.id' => ['required', 'exists:doctors,id'],
            'medical_dates' => ['required', 'array'],
            'medical_dates.*.date' => ['required', 'date'],
            'medical_dates.*.doctor.id' => ['required', 'exists:doctors,id'],
            'medical_dates.*.specialty.id' => ['required', 'exists:specialties,id'],
            // 'master_medical_date' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            // 'timezone.required' => '',
        ];
    }
}
