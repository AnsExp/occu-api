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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'roles.*' => ['required', 'string', 'max:255', Rule::exists('roles', 'name')],
            'metadata' => ['nullable', 'array'],
            'metadata.*.key' => ['required', 'string', 'max:255'],
            'metadata.*.value' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('attributes.first_name')]),
            'name.string' => __('validation.string', ['attribute' => __('attributes.first_name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('attributes.first_name'), 'max' => 255]),
            'email.required' => __('validation.required', ['attribute' => __('attributes.email')]),
            'email.email' => __('validation.email', ['attribute' => __('attributes.email')]),
            'email.max' => __('validation.max.string', ['attribute' => __('attributes.email'), 'max' => 255]),
            'email.unique' => __('validation.unique', ['attribute' => __('attributes.email')]),
            'password.string' => __('validation.string', ['attribute' => __('attributes.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('attributes.password'), 'min' => 8]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('attributes.password')]),
            'roles.*.required' => __('validation.required', ['attribute' => __('attributes.role')]),
            'roles.*.string' => __('validation.string', ['attribute' => __('attributes.role')]),
            'roles.*.exists' => __('validation.exists', ['attribute' => __('attributes.role')]),
        ];
    }
}
