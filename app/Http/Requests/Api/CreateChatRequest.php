<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'users' => 'required|array|min:2',
            'users.*' => 'integer|exists:users,id',
        ];
    }
}
