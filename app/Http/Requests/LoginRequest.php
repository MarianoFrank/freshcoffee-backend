<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|max:30",
            "password" => ['required']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Solo agregamos el campo "type" en los errores de validación
        throw new HttpResponseException(response()->json([
            'type' => 'fields',
            'errors' => $validator->errors(),
        ], 422));
    }
}
