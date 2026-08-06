<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    protected function prepareForValidation()
    {
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
            'email' => ['nullable', 'email', 'max:255'],
            'role.name' => ['required', 'string', 'max:255', Rule::exists('roles', 'name')],
        ];
        if (!$this->input('user.id')) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['nullable', 'string', 'min:8', 'same:password'];
        }
        if ($this->input('role.name') === 'doctor') {
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['specialty.id'] = ['required', 'string', 'max:255', Rule::exists('specialties', 'id')];
            $rules['id_card'] = ['required', 'string', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:255'];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('attributes.first_name')]),
            'first_name.string' => __('validation.string', ['attribute' => __('attributes.first_name')]),
            'first_name.max' => __('validation.max.string', ['attribute' => __('attributes.first_name'), 'max' => 255]),
            'email.required' => __('validation.required', ['attribute' => __('attributes.email')]),
            'email.email' => __('validation.email', ['attribute' => __('attributes.email')]),
            'email.max' => __('validation.max.string', ['attribute' => __('attributes.email'), 'max' => 255]),
            'email.unique' => __('validation.unique', ['attribute' => __('attributes.email')]),
            'password.string' => __('validation.string', ['attribute' => __('attributes.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('attributes.password'), 'min' => 8]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('attributes.password')]),
            'password_confirmation.string' => __('validation.string', ['attribute' => __('attributes.password')]),
            'password_confirmation.min' => __('validation.min.string', ['attribute' => __('attributes.password'), 'min' => 8]),
            'password_confirmation.same' => __('validation.same', ['attribute' => __('attributes.password')]),
            'role.name.required' => __('validation.required', ['attribute' => __('attributes.role')]),
            'role.name.string' => __('validation.string', ['attribute' => __('attributes.role')]),
            'role.name.max' => __('validation.max.string', ['attribute' => __('attributes.role'), 'max' => 255]),
            'role.exists' => __('validation.exists', ['attribute' => __('attributes.role')]),
            'last_name.required' => __('validation.required', ['attribute' => __('attributes.last_name')]),
            'last_name.string' => __('validation.string', ['attribute' => __('attributes.last_name')]),
            'last_name.max' => __('validation.max.string', ['attribute' => __('attributes.last_name'), 'max' => 255]),
            'specialty.id.required' => __('validation.required', ['attribute' => __('attributes.specialty')]),
            'specialty.id.string' => __('validation.string', ['attribute' => __('attributes.specialty')]),
            'specialty.id.max' => __('validation.max.string', ['attribute' => __('attributes.specialty'), 'max' => 255]),
            'id_card.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'id_card.string' => __('validation.string', ['attribute' => __('attributes.id_card')]),
            'id_card.max' => __('validation.max.string', ['attribute' => __('attributes.id_card'), 'max' => 255]),
            'phone.required' => __('validation.required', ['attribute' => __('attributes.phone')]),
            'phone.string' => __('validation.string', ['attribute' => __('attributes.phone')]),
            'phone.max' => __('validation.max.string', ['attribute' => __('attributes.phone'), 'max' => 255]),
            'id_card_hash.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'id_card_hash.string' => __('validation.string', ['attribute' => __('attributes.id_card')]),
            'id_card_hash.max' => __('validation.max.string', ['attribute' => __('attributes.id_card'), 'max' => 255]),
        ];
    }
}
