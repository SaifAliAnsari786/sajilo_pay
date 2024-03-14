<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (!empty(\request()->id)) {
            $rule['name'] = [
                'required',
                'max:255',
                'unique:departments,name,'.\request()->id
            ];
        } else {
            $rule['name'] = 'required|max:255|unique:departments,name';
        }
        return $rule;
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Please enter department name.',
            'name.max' => 'Department name must not be more than 255 characters long.',
            'name.unique' => 'Department name already taken.'
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
