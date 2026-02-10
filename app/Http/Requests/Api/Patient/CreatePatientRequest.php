<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helper\ResponseHelper;

class CreatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'identity_number' => 'required|digits:16',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'blood_type' => 'required|in:A,B,AB,O',
            'create_user' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Patient name is required.',
            'name.string' => 'Patient name must be a valid string.',
            'name.max' => 'Patient name must not exceed 255 characters.',

            'identity_number.required' => 'Identity number is required.',
            'identity_number.digits' => 'Identity number must be exactly 16 digits.',

            'email.string' => 'Email must be a valid string.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'Email already exist',

            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a valid string.',
            'phone.max' => 'Phone number must not exceed 20 characters.',

            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address must not exceed 500 characters.',

            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Birth date must be a valid date.',

            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male or female.',

            'blood_type.required' => 'Blood type is required.',
            'blood_type.in' => 'Blood type must be one of A, B, AB, or O.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstMessage = collect($validator->errors()->all())->first();

        throw new HttpResponseException(
            ResponseHelper::apiError($firstMessage, null, 422)
        );
    }
}
