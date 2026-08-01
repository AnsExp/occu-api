<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderOptionRequest extends FormRequest
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
            'order_options' => 'required|array',
            'order_options.*.id' => 'nullable|exists:order_options,id',
            'order_options.*.name' => 'required|string|max:255',
            'order_options.*.price' => 'required|numeric|min:0',
        ];
    }
}
