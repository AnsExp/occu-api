<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class LaboratoryOrderResultRequest extends FormRequest
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
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'mimes:pdf'],
        ];
    }

    public function messages()
    {
        return [
            'files.required' => __('validation.required', ['attribute' => __('attributes.files')]),
            'files.array' => __('validation.array', ['attribute' => __('attributes.files')]),
            'files.*.required' => __('validation.required', ['attribute' => __('attributes.file')]),
            'files.*.file' => __('validation.file', ['attribute' => __('attributes.file')]),
            'files.*.mimes' => __('validation.mimes', ['attribute' => __('attributes.file'), 'values' => 'pdf']),
            'timezone.required' => __('validation.required', ['attribute' => __('attributes.timezone')]),
            'timezone.string' => __('validation.string', ['attribute' => __('attributes.timezone')]),
        ];
    }
}
