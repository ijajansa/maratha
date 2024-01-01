<?php

namespace App\Http\Requests;

use App\Registration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): ?bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): ?array
    {
        return [
            'name' => 'required|max:50',
            'contact_number' => 'required|digits:10',
            'address' => 'required'
        ];
    }

    /**
     * Validation error response
     *
     * @param Validator $validator
     * @return JsonResponse|null
     */
    public function failedValidation(Validator $validator): ?JsonResponse
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'message' => $validator->messages()->first()
            ]
        ));
    }
}
