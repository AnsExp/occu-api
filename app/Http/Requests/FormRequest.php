<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class FormRequest extends BaseFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al validar los datos de la solicitud.',
                'errors' => collect($validator->errors()->all()),
            ], 422)
        );
    }
}
