<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chat_id' => 'required|string',
            'sender_id' => 'nullable|integer',
            'message' => 'nullable|string',
            'file' => 'nullable|file',
            'type' => 'nullable|string',
            'reply_to_id' => 'nullable|string',
            'reply_to_text' => 'nullable|string',
            'duration' => 'nullable|integer',
            'call_name' => 'required_if:type,scheduled_call|string',
            'description' => 'nullable|string',
            'start_time' => 'required_if:type,scheduled_call|integer',
            'end_time' => 'nullable|integer',
            'call_type' => 'required_if:type,scheduled_call|string',
            'require_approval' => 'nullable|boolean',
            'group_call_id' => 'required_if:type,scheduled_call|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ];
    }
}
