<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Contracts\Validation\ValidationRule;

class RadiologyRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (user_has_role('doctor')) {
            $doctor = Doctor::where('user_id', auth()->user()->id)->first();
            $this->merge([
                'doctor.id' => $doctor->id,
            ]);
        }
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
            'timezone' => ['required', 'string'],
            'medical_exam' => ['required', 'array'],
            'medical_exam.technique' => ['required', 'string'],
            'medical_exam.report' => ['required', 'string'],
            'medical_exam.conclusion' => ['required', 'string'],
            'medical_exam.consent_document' => ['required', 'file', 'mimes:pdf'],
            'medical_exam.x_ray_files' => ['required', 'array'],
            'medical_exam.x_ray_files.*' => ['required', 'file', 'mimes:pdf'],
        ];
    }
}
