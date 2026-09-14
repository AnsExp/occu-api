<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class RadiologyRequest extends FormRequest
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
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'mimes:pdf'],
        ];
    }

    public function messages(): array
    {
        return [
            'timezone.string' => 'The timezone must be a string.',
            'files.required' => 'The files field is required.',
            'files.array' => 'The files field must be an array.',
            'files.*.required' => 'Each file is required.',
            'files.*.file' => 'Each file must be a valid file.',
            'files.*.mimes' => 'Each file must be a PDF.',
        ];
    }
}
