<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AllowedIpRequest extends FormRequest
{
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
        $allowedIp = $this->route('allowedIp');
        return [
            'notes' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
            'ip_address' => ['required', 'string', 'max:15', Rule::unique('allowed_ips', 'ip_address')->ignore($allowedIp)],
        ];
    }

    public function messages()
    {
        return [
            'ip_address.required' => 'The IP address field is required.',
            'ip_address.string' => 'The IP address must be a string.',
            'ip_address.max' => 'The IP address may not be greater than 15 characters.',
            'ip_address.unique' => 'The IP address has already been taken.',
            'notes.required' => 'The notes field is required.',
            'notes.string' => 'The notes must be a string.',
            'notes.max' => 'The notes may not be greater than 255 characters.',
            'expires_at.datetime' => 'The expires at must be a valid date and time.',
        ];
    }
}
