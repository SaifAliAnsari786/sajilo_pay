<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'leave_type_id' => 'required|numeric',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'reason' => 'required|string|max:255'
        ];
    }

    public function messages():array
    {
        return [
            'leave_type_id.required' => 'Please select leave type.',
            'leave_type_id.numeric' => 'Leave type must be numeric.',
            'from_date.required' => 'Please pick a date.',
            'from_date.date' => 'Please enter valid date.',
            'to_date.required' => 'Please pick a date.',
            'to_date.date' => 'Please enter valid date.',
            'reason.required' => 'Please provide a reason.',
            'reason.max' => 'Reason can not be more than 255 characters long.'
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
