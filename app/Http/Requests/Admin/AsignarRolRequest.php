<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AsignarRolRequest extends BaseRequest
{
    public function authorize()
    {
        $roles = $this->user()->roles;
        foreach ($roles as $rol) {
            if($rol->id == 1)
                return true;
        }
        return false;
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
            'rols' => 'required|array|min:1',
            'rols.*' => 'numeric|exists:rols,id',
            'user' => 'required|numeric|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El :attribute es requerido',
            'array' => 'rols debe ser un array',
            'min' => 'Debe enviarse al menos un rol',
            'rols.*.exists' => 'No existe el rol',
            'user.exists' => 'No existe el usuario',
            'numeric' => ':attribute debe ser un número'
        ];
    }
}

