<?php

namespace App\Services;

use App\Services\EmbeddingService;
use App\Models\Embedding;

/**
 * Service responsible for performing vector similarity search
 * over stored document embeddings.
*/
class VectorSearchService
{
    /**
     * VectorSearchService constructor.
     *
     * @param EmbeddingService $embeddingService Service used to generate embeddings
    */
    public function __construct( protected EmbeddingService $embeddingService ) {}

    /**
     * Perform a semantic search over stored embeddings.
     *
     * Steps:
     * 1. Generate embedding for the user question
     * 2. Load all stored embeddings from database
     * 3. Compute cosine similarity between question and each chunk
     * 4. Rank results by similarity score
     * 5. Return top 3 most relevant chunks
     *
     * @param string $question User query
     * @return array<int, array<string, mixed>> Ranked search results
    */
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

    /**
     * Compute cosine similarity between two vectors.
     *
     * @param array<float> $a First vector
     * @param array<float> $b Second vector
     * @return float Similarity score between 0 and 1
    */
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