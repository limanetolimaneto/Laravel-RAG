<?php

namespace App\Services;

use App\Services\EmbeddingService;
use App\Models\Embedding;

class VectorSearchService
{
    public function __construct( protected EmbeddingService $embeddingService ) {}

    public function search(string $question): array
    {
        $questionEmbedding = $this->embeddingService->generate([$question])[0];
        $embeddings = Embedding::all();
        $results = [];

        foreach ($embeddings as $embedding) {

            $similarity = $this->cosineSimilarity(
                $questionEmbedding,
                $embedding->embedding
            );

            $results[] = [
                'document_name' => $embedding->document_name,
                'content' => $embedding->content,
                'chunk_index' => $embedding->chunk_index,
                'score' => $similarity,
            ];
        }

        usort(
            $results,
            fn ($a, $b) => $b['score'] <=> $a['score']
        );

        return array_slice($results, 0, 3);
    }

    private function cosineSimilarity( array $a, array $b ): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($a as $index => $value) {

            $dotProduct += $value * $b[$index];

            $normA += $value ** 2;

            $normB += $b[$index] ** 2;
        }

        return $dotProduct /
            (sqrt($normA) * sqrt($normB));
    }

}