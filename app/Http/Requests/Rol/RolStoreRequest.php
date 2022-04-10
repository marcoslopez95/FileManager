<?php

namespace App\Http\Requests\Rol;

use App\Http\Requests\BaseRequest;
class RolStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|string|unique:rols',
            'description' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser texto',
            'unique' => 'El campo :attribute debe ser único'
        ];
    }

}
