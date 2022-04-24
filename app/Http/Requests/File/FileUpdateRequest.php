<?php

namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class FileUpdateRequest extends BaseRequest
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
          'name' => ['required', 'string', Rule::exists('files', 'name')],
          //  'description' => 'required|string',
          'file' => [ 'required', 'file' ],
          'extension' => 'in:doc,docx,xlsx,xls,csv',
          //  'folder_id' => 'required|numeric|exists:App\Models\Folder,id'
        ];
    }


    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser texto',
            'unique' => 'El campo :attribute debe ser único',
            'numeric' => 'El campo :attribute debe ser un numero',
            'exists' => 'El archivo que va a subir debe llamarse igual al archivo que va a actualizar',
            'file' => 'Debe enviarse un archivo',

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
            'name'      => $this->file->getClientOriginalName(),
        ]);
    }
}
