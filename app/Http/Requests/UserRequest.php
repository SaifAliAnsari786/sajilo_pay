<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rule = [
            'first_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'required|max:255',
            'dob' => 'required|max:255',
            'joining_date' => 'required|max:255',
            'permanent_province' => 'nullable|max:255',
            'permanent_district' => 'nullable|max:255',
            'permanent_municipality' => 'nullable|max:255',
            'permanent_tole' => 'nullable|max:255',
            'current_province' => 'nullable|max:255',
            'current_district' => 'nullable|max:255',
            'current_municipality' => 'nullable|max:255',
            'current_tole' => 'nullable|max:255',
            'profile_image' => 'required|file|mimes:jpg,jpeg,png',
            'citizenship_front' => 'required|file|mimes:jpg,jpeg,png',
            'citizenship_back' => 'required|file|mimes:jpg,jpeg,png',
            'department_id' => 'required|max:255',
            'position_id' => 'required|max:255',
            'role_id' => 'required'
        ];
        if (!empty(\request()->userid) && (!empty(\request()->profileid))) {
            $rule['email'] = 'required|email|max:255|unique:users,email,'.\request()->userid;
            $rule['staff_id'] = 'required|numeric|max_digits:10|unique:profiles,staff_id,'.\request()->profileid;
            $rule['mobile_number_1'] = 'required|numeric|max_digits:10|unique:profiles,mobile_number_1,'.\request()->profileid;
            $rule['mobile_number_2'] = 'nullable|numeric|max_digits:10|unique:profiles,mobile_number_2,'.\request()->profileid;
        } else {
            $rule['email'] = 'required|email|max:255|unique:users,email';
            $rule['staff_id'] = 'required|numeric|max_digits:10|unique:profiles,staff_id';
            $rule['mobile_number_1'] = 'required|numeric|max_digits:10|unique:profiles,mobile_number_1';
            $rule['mobile_number_2'] = 'nullable|numeric|max_digits:10|unique:profiles,mobile_number_2';
        }
        return $rule;
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter first name.',
            'first_name.max' => 'First name must not be more than 255 characters long.',
            'middle_name.max' => 'Middle name must not be more than 255 characters long.',
            'last_name.required' => 'Please enter last name.',
            'last_name.max' => 'Last name must not be more than 255 characters long.',
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'email.max' => 'Email must not be more than 255 characters long.',
            'email.unique' => 'Email already taken.',
            'dob.required' => 'Please select date of birth.',
            'joining_date.required' => 'Please select joining date.',
            'mobile_number_1.required' => 'Please provide primary mobile number.',
            'mobile_number_1.numeric' => 'Please provide primary mobile number.',
            'mobile_number_1.digits' => 'Primary mobile number must be of 10 digits.',
            'mobile_number_1.unique' => 'Primary mobile number already taken.',
            'mobile_number_2.numeric' => 'Please provide secondary mobile number.',
            'mobile_number_2.digits' => 'Secondary mobile number must be of 10 digits.',
            'mobile_number_2.unique' => 'Secondary mobile number already taken.',
            'profile_image.mimes' => 'Supported files are (JPG/JPEG/PNG).',
            'citizenship_front.mimes' => 'Supported files are (JPG/JPEG/PNG).',
            'citizenship_back.mimes' => 'Supported files are (JPG/JPEG/PNG).',
            'department_id.required' => 'Please select department.',
            'position_id.required' => 'Please select position.',
            'staff_id.required' => 'Please provide staff id.',
            'staff_id.numeric' => 'Staff id must be digits.',
            'role_id.required' => 'Please select at least one role.'
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
