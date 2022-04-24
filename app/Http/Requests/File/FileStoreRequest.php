<?php

namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;

class FileStoreRequest extends BaseRequest
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
            //'name' => 'required|string|unique:files',
            'file' => ['required', 'file'],
            'extension' => 'in:doc,docx,xls,xls,csv',
            'description' => 'required|string',
            'folder' => 'required|string|exists:folders,name'
        ];
    }


    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser texto',
            'mimes' => 'Solo se permiten archivos con extension: :values',
            'unique' => 'El campo :attribute debe ser único',
            'numeric' => 'El campo :attribute debe ser un numero',
            'exists' => 'El campo :attribute no es una carpeta',
            'in' => 'Solo se permiten archivos con extension: :values'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'extension' => $this->file->getClientOriginalExtension(),
        ]);
    }
}
