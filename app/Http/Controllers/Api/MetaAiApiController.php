<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaAiApiController extends Controller
{
    use \App\Traits\ApiResponse;

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
        ]);

        $apiKey = env('GROQ_API_KEY');

        if (empty($apiKey)) {
            return $this->errorResponse('API key is missing.', 500);
        }

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are Meta AI, a helpful and friendly AI assistant integrated into a messaging app. Answer concisely and use markdown for formatting if needed. You have access to the web_search tool to look up real-time information or current events when the user\'s message asks for it.',
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

        $tools = [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'web_search',
                    'description' => 'Search the web for real-time information, latest news, current events, or up-to-date facts.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'query' => [
                                'type' => 'string',
                                'description' => 'The search query to look up on the web.'
                            ]
                        ],
                        'required' => ['query']
                    ]
                ]
            ]
        ];

        try {
            $response = Http::withToken($apiKey)
                ->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => $messages,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                    'tools' => $tools,
                    'tool_choice' => 'auto'
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['choices'][0]['message']['tool_calls'])) {
                    $toolCalls = $data['choices'][0]['message']['tool_calls'];
                    
                    $messages[] = $data['choices'][0]['message'];

                    foreach ($toolCalls as $toolCall) {
                        if ($toolCall['function']['name'] === 'web_search') {
                            $arguments = json_decode($toolCall['function']['arguments'], true);
                            $query = $arguments['query'] ?? $userMessage;

                            $searchResult = $this->searchWeb($query);

                            $messages[] = [
                                'role' => 'tool',
                                'tool_call_id' => $toolCall['id'],
                                'name' => 'web_search',
                                'content' => $searchResult,
                            ];
                        }
                    }

                    $finalResponse = Http::withToken($apiKey)
                        ->timeout(60)
                        ->post('https://api.groq.com/openai/v1/chat/completions', [
                            'model' => 'llama-3.3-70b-versatile',
                            'messages' => $messages,
                            'max_tokens' => 1000,
                            'temperature' => 0.7,
                        ]);

                    if ($finalResponse->successful()) {
                        $finalData = $finalResponse->json();
                        $reply = $finalData['choices'][0]['message']['content'] ?? 'I could not generate a response.';
                        return $this->successResponse(['reply' => $reply]);
                    } else {
                        Log::error('OpenAI API Final Call Error: '.$finalResponse->body());
                        return $this->errorResponse('Failed to connect to AI.', 500);
                    }
                }

                $reply = $data['choices'][0]['message']['content'] ?? 'I could not generate a response.';
                return $this->successResponse(['reply' => $reply]);
            } else {
                Log::error('OpenAI API Error: '.$response->body());
                return $this->errorResponse('Failed to connect to AI.', 500);
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: '.$e->getMessage());
            return $this->errorResponse('An error occurred while processing your request.', 500);
        }
    }

    private function searchWeb($query)
    {
        $postdata = http_build_query([
            'q' => $query
        ]);

        $context = stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded\r\n" .
                            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n" .
                            "Content-Length: " . strlen($postdata) . "\r\n",
                "content" => $postdata,
                "timeout" => 10
            ]
        ]);

        $html = @file_get_contents("https://lite.duckduckgo.com/lite/", false, $context);

        if (empty($html) || strpos($html, "anomaly") !== false) {
            return "Search failed or rate-limited.";
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $links = $xpath->query('//a[@class="result-link"]');
        $results = [];

        foreach ($links as $linkNode) {
            $title = trim($linkNode->textContent);
            $link = $linkNode->getAttribute('href');

            if (preg_match('/uddg=([^&]+)/', $link, $matches)) {
                $link = urldecode($matches[1]);
            }

            $trNode = $linkNode->parentNode;
            while ($trNode && $trNode->nodeName !== 'tr') {
                $trNode = $trNode->parentNode;
            }

            $snippet = '';
            if ($trNode) {
                $nextTr = $trNode->nextSibling;
                while ($nextTr && $nextTr->nodeName !== 'tr') {
                    $nextTr = $nextTr->nextSibling;
                }
                if ($nextTr) {
                    $snippetTd = $xpath->query('.//td[@class="result-snippet"]', $nextTr)->item(0);
                    if ($snippetTd) {
                        $snippet = trim($snippetTd->textContent);
                    }
                }
            }

            $results[] = "Title: $title\nURL: $link\nSnippet: $snippet\n---";
            if (count($results) >= 4) {
                break;
            }
        }

        return count($results) > 0 ? implode("\n\n", $results) : "No search results found.";
    }
}
