<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helper\ResponseHelper;

class UpdatePatientRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'identity_number' => 'sometimes|digits:16',
            'email' => 'sometimes|string|email|max:255',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:500',
            'birth_date' => 'sometimes|date',
            'gender' => 'sometimes|in:male,female',
            'blood_type' => 'sometimes|in:A,B,AB,O',
            'create_user' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Patient name must be a valid string.',
            'name.max' => 'Patient name must not exceed 255 characters.',

            'identity_number.digits' => 'Identity number must be exactly 16 digits.',

            'email.email' => 'Email must be a valid email address.',

            'phone.string' => 'Phone number must be a valid string.',
            'phone.max' => 'Phone number must not exceed 20 characters.',

            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address must not exceed 500 characters.',

            'birth_date.date' => 'Birth date must be a valid date.',

            'gender.in' => 'Gender must be either male or female.',

            'blood_type.in' => 'Blood type must be one of A, B, AB, or O.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseHelper::apiError(
                $validator->errors()->first(),
                null,
                422
            )
        );
    }
}
