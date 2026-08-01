<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VitalSignRequest extends FormRequest
{
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
            'specialty.id' => ['required', 'exists:specialties,id'],
            'medical_date.id' => ['required', 'exists:medical_dates,id'],
            'height' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'pulse' => ['required', 'numeric', 'min:0'],
            'glucose' => ['required', 'numeric', 'min:0'],
            'blood_pressure_systolic' => ['required', 'numeric', 'min:0'],
            'blood_pressure_diastolic' => ['required', 'numeric', 'min:0'],
            'emo' => ['required', 'string', 'max:255'],
            'protein' => ['required', 'string', 'max:255'],
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+.AB-,O+,O-'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
