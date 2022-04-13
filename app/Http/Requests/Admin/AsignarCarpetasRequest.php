<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AsignarCarpetasRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $roles = $this->user()->roles;
        foreach ($roles as $rol) {
            if ($rol->id == 1)
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
            'folders' => 'required|array|min:1',
            'folders.*' => 'numeric|exists:folders,id',
            'permits' => 'required|array|min:1',
            'permits.*' => 'numeric|exists:permits,id',
            'user' => 'required|numeric|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El :attribute es requerido',
            'array' => 'files debe ser un array',
            'min' => 'Debe enviarse al menos un rol',
            'files.*.exists' => 'No existe el rol',
            'user.exists' => 'No existe el usuario',
            'numeric' => ':attribute debe ser un número'
        ];
    }
}