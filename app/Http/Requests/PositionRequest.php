<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // dd(97);

        if (!empty(\request()->id)) {
            $rule['name'] = [
                'required',
                'max:255',
                'unique:positions,name,'.\request()->id
            ];
        } else {
            $rule['name'] = 'required|max:255|unique:positions,name';
        }
        return $rule;
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Please enter position name.',
            'name.max' => 'postion name must not be more than 255 characters long.',
            'name.unique' => 'postion name already taken.'
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
