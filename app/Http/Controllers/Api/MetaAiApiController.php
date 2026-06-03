<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaAiApiController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
        ]);

        $apiKey = env('GROQ_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'API key is missing.'], 500);
        }

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are Meta AI, a helpful and friendly AI assistant integrated into a messaging app. Answer concisely and use markdown for formatting if needed.',
            ],
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'assistant',
                'content' => $msg['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $userMessage,
        ];

        try {
            $response = Http::withToken($apiKey)
                ->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => $messages,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'I could not generate a response.';

                return response()->json(['reply' => $reply]);
            } else {
                Log::error('OpenAI API Error: '.$response->body());

                return response()->json(['error' => 'Failed to connect to AI.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: '.$e->getMessage());

            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
}
