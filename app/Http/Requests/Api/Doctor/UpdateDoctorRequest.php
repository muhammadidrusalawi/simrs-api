<?php

namespace App\Http\Requests\Api\Doctor;

use App\Helper\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDoctorRequest extends FormRequest
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
            'email' => 'sometimes|string|email|max:255',
            'specialization' => 'sometimes|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Doctor name must be a valid string.',
            'name.max' => 'Doctor name must not exceed 255 characters.',

            'email.email' => 'Email must be a valid email address.',

            'specialization.string' => 'Specialization must be a valid string.',
            'specialization.max' => 'Specialization must not exceed 100 characters.',
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
