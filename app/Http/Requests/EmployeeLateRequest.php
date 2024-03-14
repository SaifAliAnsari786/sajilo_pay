<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeLateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'arrival_time' => 'required',
            'date' => 'required|date',
            'reason' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
          'arrival_time.required' => 'Please provide arrival time.',
          'date.required' => 'Please provide date.',
          'date.date' => 'Please provide valid date.',
          'reason.required' => 'Please provide a reason.',
          'reason.max' => 'Reason can not be more than 255 characters long.',
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
