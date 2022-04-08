<?php

namespace App\Http\Requests\Folder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FolderUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('folders', 'name')->ignore($this->folder),],
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