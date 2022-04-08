<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'required|string|unique:files',
            'description' => 'required|string',
            'folder_id' => 'required|numeric|exists:folders,id'
        ];
    }


    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser texto',
            'unique' => 'El campo :attribute debe ser único',
            'numeric' => 'El campo :attribute debe ser un numero',
            'exists' => 'El campo :attribute no es una carpeta'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new Response([
            'status' => 422,
            'error' => true,
            'message' => $validator->errors()->first()
        ], 422);
        throw new ValidationException($validator, $response);
    }
}