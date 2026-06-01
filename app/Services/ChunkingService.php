<?php

namespace App\Services;

class ChunkingService
{
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


