<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OccupationalMedicineRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!user_has_role('doctor')) {
            return;
        }

        $user = auth()->user();

        if (!$user->roles->contains('occupational_medicine')) {
            return;
        }

        $doctor = Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            return;
        }

        $this->merge(['doctor.id' => $doctor->id]);
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
        $rules = [
            'timezone' => ['required', 'string'],
            'medical_date.id' => ['required', 'numeric', 'exists:medical_dates,id'],
            'medical_exam' => ['required', 'array'],
            'medical_exam.koh' => ['required', 'string'],
            'medical_exam.ecg' => ['required', 'string'],
            'medical_exam.vdrl' => ['required', 'string'],
            'medical_exam.copro' => ['required', 'string'],
            'medical_exam.extra_tests' => ['required', 'string'],
            'medical_exam.dental_assessment' => ['required', 'string'],
            'medical_exam.psychological_assessment' => ['required', 'string'],
            'medical_exam.other_tests.*.test' => ['required', 'string'],
            'medical_exam.other_tests.*.result' => ['nullable', 'string'],
            'medical_exam.other_tests.*.status' => ['required', 'string', 'in:normal,abnormal'],
            'medical_exam.aptitude_eval.observations' => ['nullable', 'string'],
            'medical_exam.aptitude_eval.restrictions' => ['required', 'boolean'],
            'medical_exam.aptitude_eval.watchkeeping' => ['required', 'in:fit,unfit'],
            'medical_exam.aptitude_eval.service_matrix' => ['required', 'array'],
            'medical_exam.aptitude_eval.service_matrix.*' => ['required', 'in:fit,unfit'],
            'medical_exam.aptitude_eval.corrective_lenses' => ['required', 'boolean'],
            'medical_exam.aptitude_eval.restriction_description' => ['nullable', 'string'],
            'medical_exam.clinical_data' => ['required', 'array'],
            'medical_exam.clinical_data.blood_pressure_systolic' => ['required', 'numeric'],
            'medical_exam.clinical_data.blood_pressure_diastolic' => ['required', 'numeric'],
            'medical_exam.clinical_data.blood_type' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'medical_exam.clinical_data.chest_xray.status' => ['required', 'string', 'in:was_done,not_done'],
            'medical_exam.clinical_data.chest_xray.date' => ['nullable', 'date'],
            'medical_exam.clinical_data.chest_xray.result' => ['nullable', 'string'],
            'medical_exam.clinical_data.emo' => ['required', 'string'],
            'medical_exam.clinical_data.glucose' => ['required', 'string'],
            'medical_exam.clinical_data.observations' => ['nullable', 'string'],
            'medical_exam.clinical_data.protein' => ['required', 'string'],
            'medical_exam.clinical_data.height' => ['required', 'numeric'],
            'medical_exam.clinical_data.weight' => ['required', 'numeric'],
            'medical_exam.clinical_data.pulse' => ['required', 'numeric'],
            'medical_exam.clinical_data.checks' => ['required', 'array'],
            'medical_exam.clinical_data.checks.*' => ['required', 'in:normal,abnormal'],
            'medical_exam.declarations' => ['required', 'array'],
            'medical_exam.declarations.*.questions.*' => ['required', 'boolean'],
            'medical_exam.declarations.*.aclarations' => ['nullable', 'string'],
            'medical_exam.observations' => ['nullable', 'string'],
        ];
        if ($this->boolean($this->input('medical_exam.aptitude_eval.restrictions'))) {
            $rules['medical_exam.aptitude_eval.restriction_description'] = ['required', 'string'];
        }
        if ($this->input('medical_exam.clinical_data.chest_xray.status') === 'was_done') {
            $rules['medical_exam.clinical_data.chest_xray.date'] = ['required', 'date'];
            $rules['medical_exam.clinical_data.chest_xray.result'] = ['required', 'string'];
        }
        return $rules;
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
        ];
    }
}
