<?php

namespace App\Http\Requests\Rol;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RolUpdateRequest extends BaseRequest
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
            'name' => ['required', 'string', Rule::unique('rols', 'name')->ignore($this->permit),],
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
