<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class LaboratoryOrderRequest extends FormRequest
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
        return [
            'person.id_card' => ['required', 'numeric', 'exists:personal_data,id_card'],
            'timezone' => ['required', 'string'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'numeric', 'exists:laboratory_options,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'person.id_card.required' => __('validation.required', ['attribute' => __('attributes.id_card')]),
            'person.id_card.numeric' => __('validation.numeric', ['attribute' => __('attributes.id_card')]),
            'person.id_card.exists' => __('validation.exists', ['attribute' => __('attributes.id_card')]),
            'timezone.required' => __('validation.required', ['attribute' => __('attributes.timezone')]),
            'timezone.string' => __('validation.string', ['attribute' => __('attributes.timezone')]),
            'items.required' => __('validation.required', ['attribute' => __('attributes.item')]),
            'items.array' => __('validation.array', ['attribute' => __('attributes.item')]),
            'items.*.id.required' => __('validation.required', ['attribute' => __('attributes.option')]),
            'items.*.id.numeric' => __('validation.numeric', ['attribute' => __('attributes.option')]),
            'items.*.id.exists' => __('validation.exists', ['attribute' => __('attributes.option')]),
            'items.*.quantity.numeric' => __('validation.numeric', ['attribute' => __('attributes.quantity')]),
            'items.*.quantity.min' => __('validation.min.numeric', ['attribute' => __('attributes.quantity'), 'min' => 1]),
        ];
    }
}
