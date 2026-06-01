<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    public function generate(array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.jina.api-key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.jina.ai/v1/embeddings', [
            'model' => 'jina-embeddings-v2-base-en',
            'input' => $data,
        ]);

        // return $response->json();
        return collect($response['data'])
            ->pluck('embedding')
            ->toArray();
    }
}
