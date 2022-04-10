<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            //
            'email'     => 'required|string|exists:users',
            'password'  => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => ':attribute es requerido',
            'password.required'     => ':attribute es requerida',
            'string'                => 'El campo :attribute debe ser un texto',
            'password.min'          => 'La contraseña debe ser mínimo de 6 caractéres',
            'exists'                => 'El correo no está registrado'
        ];
    }

    public function attributes()
    {
        return [
            'email'     => 'El correo electrónico',
            'password'  => 'La contraseña'
        ];
    }

}
