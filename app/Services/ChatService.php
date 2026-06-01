<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ChatService
{
    public function answer(string $prompt): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.api-key'),
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        return $response['choices'][0]['message']['content'];
    }
}