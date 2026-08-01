<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PsychologyRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!user_has_role('doctor')) {
            return;
        }

        $user = auth()->user();

        if (!$user->roles->contains('audiology')) {
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
        return [
            'timezone' => ['required', 'string'],
            'doctor.id' => ['required', 'exists:doctors,id'],
            'order.order_number' => ['required', 'exists:orders,order_number'],
            'medical_exam' => ['required', 'array'],
            'medical_exam.stress_scale' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.mcmi_iiab_one' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.mcmi_iiab_two' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.mini_mental_state' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.consent_and_authorization' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.informed_consent' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'medical_exam.roadmap' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'doctor.id.required' => __('validation.required', ['attribute' => __('psychology.doctor')]),
            'doctor.id.exists' => __('validation.exists', ['attribute' => __('psychology.doctor')]),
            'order.order_number.required' => __('validation.required', ['attribute' => __('psychology.order_number')]),
            'order.order_number.exists' => __('validation.exists', ['attribute' => __('psychology.order_number')]),
            'medical_exam.stress_scale.required' => __('validation.required', ['attribute' => __('psychology.medical_exam.stress_scale')]),
            'medical_exam.stress_scale.file' => __('validation.file', ['attribute' => __('psychology.medical_exam.stress_scale')]),
            'medical_exam.stress_scale.mimes' => __('validation.mimes', ['attribute' => __('psychology.medical_exam.stress_scale'), 'values' => 'pdf']),
            'medical_exam.stress_scale.max' => __('validation.max.file', ['attribute' => __('psychology.medical_exam.stress_scale'), 'max' => 5120]),
            'medical_exam.mcmi_iiab_one.required' => __('validation.required', ['attribute' => __('psychology.medical_exam.mcmi_iiab_one')]),
            'medical_exam.mcmi_iiab_one.file' => __('validation.file', ['attribute' => __('psychology.medical_exam.mcmi_iiab_one')]),
            'medical_exam.mcmi_iiab_one.mimes' => __('validation.mimes', ['attribute' => __('psychology.medical_exam.mcmi_iiab_one'), 'values' => 'pdf']),
            'medical_exam.mcmi_iiab_one.max' => __('validation.max.file', ['attribute' => __('psychology.medical_exam.mcmi_iiab_one'), 'max' => 5120]),
            'medical_exam.mcmi_iiab_two.required' => __('validation.required', ['attribute' => __('psychology.medical_exam.mcmi_iiab_two')]),
            'medical_exam.mcmi_iiab_two.file' => __('validation.file', ['attribute' => __('psychology.medical_exam.mcmi_iiab_two')]),
            'medical_exam.mcmi_iiab_two.mimes' => __('validation.mimes', ['attribute' => __('psychology.medical_exam.mcmi_iiab_two'), 'values' => 'pdf']),
            'medical_exam.mcmi_iiab_two.max' => __('validation.max.file', ['attribute' => __('psychology.medical_exam.mcmi_iiab_two'), 'max' => 5120]),
            'medical_exam.mini_mental_state.required' => __('validation.required', ['attribute' => __('psychology.medical_exam.mini_mental_state')]),
            'medical_exam.mini_mental_state.file' => __('validation.file', ['attribute' => __('psychology.medical_exam.mini_mental_state')]),
            'medical_exam.mini_mental_state.mimes' => __('validation.mimes', ['attribute' => __('psychology.medical_exam.mini_mental_state'), 'values' => 'pdf']),
            'medical_exam.mini_mental_state.max' => __('validation.max.file', ['attribute' => __('psychology.medical_exam.mini_mental_state'), 'max' => 5120]),
        ];
    }
}
