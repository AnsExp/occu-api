<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $user = auth()->user();

        if (!$this->has('doctor.id')) {
            if ($user->hasRole('doctor')) {
                $this->merge([
                    'doctor.id' => $user->person?->doctor?->id,
                ]);
            }
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
            'person.id' => ['required', 'exists:personal_data,id'],
            'doctor.id' => ['nullable', 'exists:doctors,id'],
            'notes' => ['nullable', 'string'],
            'medications' => ['required', 'array'],
            'medications.*.id' => ['required', 'exists:medications,id'],
            'medications.*.quantity' => ['required', 'numeric', 'min:0'],
            'medications.*.notes' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'timezone.required' => '',
        ];
    }
}
