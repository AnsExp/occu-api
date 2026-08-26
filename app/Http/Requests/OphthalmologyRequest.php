<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OphthalmologyRequest extends FormRequest
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
        $rules = [
            'timezone' => ['required', 'string'],
            'medical_date.id' => ['required', 'exists:medical_dates,id'],
            'medical_exam' => ['required', 'array'],
            'medical_exam.corrective_lenses.usage' => ['required', 'string', 'in:no_usage,glasses,contact_lenses,both'],
            'medical_exam.color_vision' => ['required', 'string', 'in:not_tested,doubtful,normal,defective'],
            'medical_exam.visual_field' => ['required', 'array'],
            'medical_exam.visual_field.right' => ['required', 'string', 'in:normal,defective'],
            'medical_exam.visual_field.left' => ['required', 'string', 'in:normal,defective'],
            'medical_exam.ishihara' => ['required', 'array'],
            'medical_exam.ishihara.*' => ['required', 'string', 'in:N,CP'],
            'medical_exam.visual_acuity' => ['required', 'array'],
            'medical_exam.visual_acuity.near.with.*' => ['required', 'string', 'regex:/^(20|6)\/([1-9][0-9]*)$/'],
            'medical_exam.visual_acuity.near.without.*' => ['required', 'string', 'regex:/^(20|6)\/([1-9][0-9]*)$/'],
            'medical_exam.visual_acuity.distance.with.*' => ['required', 'string', 'regex:/^(20|6)\/([1-9][0-9]*)$/'],
            'medical_exam.visual_acuity.distance.without.*' => ['required', 'string', 'regex:/^(20|6)\/([1-9][0-9]*)$/'],
        ];
        if ($this->input('medical_exam.corrective_lenses.usage') !== 'no_usage') {
            $rules['medical_exam.corrective_lenses.function'] = ['required', 'string'];
        }
        return $rules;
    }
}
