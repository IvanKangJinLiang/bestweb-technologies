<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : $user;

        return [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($userId)],
            'phone_number' => ['sometimes', 'string', Rule::unique('users')->ignore($userId)],
            'status' => 'sometimes|in:active,inactive',
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