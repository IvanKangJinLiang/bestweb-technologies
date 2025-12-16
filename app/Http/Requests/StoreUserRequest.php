<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string|min:6',
            'status' => 'required|in:active,inactive',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // 1. Check if the URL starts with "api/"
        if ($this->is('api/*')) {
            // It's the API/Swagger -> Force JSON
            throw new HttpResponseException(response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        // 2. It's the Website -> Do default behavior (Redirect back to form)
        parent::failedValidation($validator);
    }
}