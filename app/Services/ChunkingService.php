<?php

namespace App\Services;

/**
 * Service responsible for splitting raw text into smaller overlapping chunks.
 * This is commonly used before generating embeddings in RAG pipelines.
*/
class ChunkingService
{
    /**
     * Split a text into fixed-size overlapping chunks.
     *
     * @param string $text The input text to be chunked
     * @param int $chunkSize Maximum size of each chunk in characters
     * @param int $overlap Number of overlapping characters between chunks
     * @return array<int, string> List of text chunks
    */
    public function chunk( string $text, int $chunkSize = 100, int $overlap = 20): array {
        $chunks = [];
        $start = 0;
        $textLength = strlen($text);
        while ($start < $textLength) {
            $chunks[] = substr($text, $start, $chunkSize);
            $start += ($chunkSize - $overlap);
        }
        return $chunks;
    }
}


