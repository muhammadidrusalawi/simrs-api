<?php

namespace App\Http\Requests\Api\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helper\ResponseHelper;

class CreateDoctorRequest extends FormRequest
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
            'specialization' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Doctor name is required.',
            'name.string' => 'Doctor name must be a valid string.',
            'name.max' => 'Doctor name must not exceed 255 characters.',

            'specialization.required' => 'Specialization is required.',
            'specialization.max' => 'Specialization must not exceed 100 characters.',

            'remail.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'Email already exist',
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
