<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AiThemeController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'width' => 'nullable|integer|min:256|max:3840',
            'height' => 'nullable|integer|min:256|max:3840'
        ]);

        $userPrompt = $request->input('prompt');
        $width = $request->input('width', 1080);
        $height = $request->input('height', 1920);
        $apiKey = env('GROQ_API_KEY');

        try {
            // 1. Enhance the prompt using Groq
            if ($apiKey) {
                $groqResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert AI image prompt engineer. Expand the user idea into a highly detailed, visually stunning image prompt for an AI generator. CRITICAL: Keep it strictly under 25 words. Output ONLY the raw prompt. NO introductory text, NO quotes, NO markdown. Just the prompt itself.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $userPrompt
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 50,
                ]);

                if ($groqResponse->successful()) {
                    $data = $groqResponse->json();
                    if (isset($data['choices'][0]['message']['content'])) {
                        // Clean up just in case
                        $cleanedPrompt = trim($data['choices'][0]['message']['content']);
                        $cleanedPrompt = preg_replace('/^(Here is|The prompt|Prompt:)/i', '', $cleanedPrompt);
                        $userPrompt = trim(trim($cleanedPrompt, '"\'*'));
                    }
                } else {
                    Log::error('Groq API Error: ' . $groqResponse->body());
                }
            }

            // 2. Generate Image URLs via Pollinations AI (Using 'flux' model for much better quality)
            // We generate 4 different variations by using different seeds
            // Pollinations AI blocks concurrent requests (Http::pool) for the heavy 'flux' model.
            // We must download them sequentially to guarantee they all succeed.
            // The user explicitly stated they don't mind waiting longer for proper generation.
            $encodedPrompt = rawurlencode(substr($userPrompt, 0, 800)); 
            // Increase time limit significantly because we are sleeping 32 seconds between 4 requests
            set_time_limit(300);
            
            $imageUrls = [];
            // Generate 4 images sequentially with a 32-second sleep to completely bypass Pollinations IP rate limits.
            // The user explicitly stated they don't mind waiting ("bhale ne genrate krta var lagee").
            for ($i = 0; $i < 4; $i++) {
                $seed = rand(1, 999999);
                $pollinationsUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width={$width}&height={$height}&nologo=true&model=flux&enhance=true&seed={$seed}";
                
                try {
                    $imageResponse = Http::timeout(40)->get($pollinationsUrl);
                    if ($imageResponse->successful()) {
                        $filename = 'ai_themes/' . uniqid('theme_', true) . '.jpg';
                        Storage::disk('public')->put($filename, $imageResponse->body());
                        $imageUrls[] = '/storage/' . $filename;
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to download Pollinations image (Seed $seed): " . $e->getMessage());
                }
                
                if ($i < 3) {
                    sleep(32); // Crucial: Bypasses the strict 1 request/minute IP rate limit
                }
            }

            if (empty($imageUrls)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate images. Please try again later.'
                ]);
            }

            return response()->json([
                'success' => true,
                'imageUrls' => $imageUrls,
                'enhancedPrompt' => $userPrompt
            ]);

        } catch (\Exception $e) {
            Log::error('AI Theme Generation Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate theme. Please try again later.'
            ], 500);
        }
    }

    public function editPrompt(Request $request)
    {
        $request->validate([
            'original_prompt' => 'required|string|max:2000',
            'action' => 'required|string|max:50', // Add, Remove, Change
            'edit_text' => 'required|string|max:1000'
        ]);

        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return response()->json(['prompt' => $request->original_prompt . ', ' . $request->action . ' ' . $request->edit_text]);
        }

        $sysPrompt = "You are an AI prompt rewriting engine for an image generator. The user has an original image prompt and wants to modify it. " .
                     "Action requested: '{$request->action}'. Edit instruction: '{$request->edit_text}'. " .
                     "Rewrite the original prompt intelligently to apply this edit. " .
                     "If action is Remove, ensure the item is strictly excluded from the description without using the word 'remove'. " .
                     "If action is Add, integrate the new item naturally. " .
                     "If action is Change, replace the original element seamlessly. " .
                     "Keep it highly descriptive but STRICTLY UNDER 30 words. Output ONLY the new raw prompt, no intro/outro, no quotes.";
                     
        try {
            $groqResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $sysPrompt],
                    ['role' => 'user', 'content' => "Original prompt: " . $request->original_prompt]
                ],
                'temperature' => 0.3,
                'max_tokens' => 50,
            ]);

            if ($groqResponse->successful()) {
                $data = $groqResponse->json();
                $newPrompt = trim($data['choices'][0]['message']['content']);
                $newPrompt = preg_replace('/^(Here is|The prompt|Prompt:)/i', '', $newPrompt);
                $newPrompt = trim(trim($newPrompt, '"\'*'));
                return response()->json(['prompt' => $newPrompt]);
            }
        } catch (\Exception $e) {
            Log::error('Groq Edit API Error: ' . $e->getMessage());
        }
        
        return response()->json(['prompt' => $request->original_prompt . ', ' . $request->action . ' ' . $request->edit_text]);
    }
}
