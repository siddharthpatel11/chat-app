<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ForwardMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'messages' => 'required|array|min:1',
            'messages.*.chat_id' => 'required|string',
            'messages.*.message_id' => 'required|string',
            'target_chat_ids' => 'required|array|min:1',
            'target_chat_ids.*' => 'required|string',
        ];
    }
}
