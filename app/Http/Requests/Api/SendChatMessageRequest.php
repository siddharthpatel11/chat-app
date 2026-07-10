<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendChatMessageRequest extends FormRequest
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
            'chat_id' => 'required',
            'type' => 'required|in:text,image,video,audio,document,location,live_location,scheduled_call',
            'message' => 'nullable|string',
            'file' => 'nullable|file',
            'reply_to_id' => 'nullable|string',
            'reply_to_text' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'duration' => 'nullable|string',
        ];
    }
}
