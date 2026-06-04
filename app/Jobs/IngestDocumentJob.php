<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\DocumentParserFactory;
use App\Services\ChunkingService;
use App\Services\EmbeddingService;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Embedding;
use Illuminate\Support\Facades\DB;
use App\Exceptions\EmbeddingPersistenceException;

class IngestDocumentJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    /**
     * Job responsible for processing a document and persisting its vector embeddings.
    */
    public function __construct(protected string $fileName){}

    /**
     * Execute the document ingestion pipeline:
     * 1. Select the correct parser for the file type
     * 2. Parse raw document content
     * 3. Split content into chunks
     * 4. Generate embeddings for each chunk
     * 5. Persist embeddings in the database inside a transaction
     *
     * @param DocumentParserFactory $parser
     * @param ChunkingService $chunk
     * @param EmbeddingService $embed
     *
     * @throws EmbeddingPersistenceException
    */
    public function handle(DocumentParserFactory $parser, ChunkingService $chunk, EmbeddingService $embed): void
    {
        $parserClass = $parser->make($this->fileName);
        $parsed = $parserClass->parse($this->fileName); 
        $chunkArray = $chunk->chunk($parsed);
        $embedArray = $embed->generate($chunkArray);
        Log::info($embedArray);
        foreach ($embedArray as $key => $value) {
            $embeded [] = [
                'document_name' => basename($this->fileName),
                'content' => $chunkArray[$key],
                'embedding' => json_encode($value),
                'chunk_index' => $key,
                'created_at' => now(), 
                'updated_at'    => now(),
            ];            
        }
        try {
            DB::transaction(function () use ($embeded) {
                Embedding::insert($embeded);
            });
        } catch (\Throwable $e) {
            Log::error('Error saving embeddings', [
                    'file' => $this->fileName,
                    'message' => $e->getMessage(),
                ]);
            throw new EmbeddingPersistenceException(
                'Failed to persist embeddings.',
                previous: $e
            );

        }
    }
}
