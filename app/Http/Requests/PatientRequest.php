<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
{
    private ?Patient $patient = null;

    public function setPatient(Patient $patient): void
    {
        $this->patient = $patient;
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'id_card_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ];

        if ($this->patient) {
            $rules['id_card'][] = ['required', 'string', 'max:255', Rule::unique('patients', 'id_card')->ignore($this->patient->id)];
            $rules['email'][] = ['nullable', 'email', 'max:255', Rule::unique('patients', 'email')->ignore($this->patient->id)];
            $rules['phone'][] = ['nullable', 'string', 'max:255', Rule::unique('patients', 'phone')->ignore($this->patient->id)];
        } else {
            $rules['id_card'][] = ['required', 'string', 'max:255', Rule::unique('patients', 'id_card')];
            $rules['email'][] = ['nullable', 'email', 'max:255', Rule::unique('patients', 'email')];
            $rules['phone'][] = ['nullable', 'string', 'max:255', Rule::unique('patients', 'phone')];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'nationality.required' => 'La nacionalidad es obligatoria.',
            'gender.required' => 'El género es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'id_card.required' => 'La cédula es obligatoria.',
            'id_card.unique' => 'La cédula ya está en uso.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'phone.unique' => 'El teléfono ya está en uso.',
            'id_card_file.file' => 'El archivo de la cédula debe ser un archivo válido.',
            'id_card_file.mimes' => 'El archivo de la cédula debe ser un archivo de tipo: pdf, jpg, jpeg, png, webp.',
            'id_card_file.max' => 'El archivo de la cédula no debe ser mayor a 5MB.',
        ];
    }
}
