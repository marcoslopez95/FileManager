<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6',
            'name' => 'required|string|min:3',
            'last_names' => 'required|string|min:3'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El :attribute es requerido',
            'email' => 'Debe introducir un correo electronico',
            'unique' => 'El correo ya está registrado',
            'confirmed' => 'Las contraseñas no coinciden',
            'min' => 'el campo :attribute debe ser de al menos :min caracteres',
        ];
    }
}