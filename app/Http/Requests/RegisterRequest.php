<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|min:4|max:20",
            "email" => "required|email|max:30|unique:users",
            "password" => ['required', 'confirmed', Password::min(6)]
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
