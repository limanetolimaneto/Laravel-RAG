<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Service responsible for generating vector embeddings
 * from text chunks using an external embeddings API.
*/
class EmbeddingService
{
    /**
     * Generate embeddings for an array of text inputs.
     *
     * @param array<int, string> $data List of text chunks
     * @return array<int, array<float>> List of embedding vectors
    */
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
