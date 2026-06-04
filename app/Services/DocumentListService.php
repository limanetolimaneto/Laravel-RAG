<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

/**
 * Service responsible for retrieving available documents
 * from the local RAG (Retrieval-Augmented Generation) storage directory.
*/
class DocumentListService
{
    /**
     * Returns a list of files available for ingestion.
     *
     * @return array<File>
    */
    public function list(): array
    {
        return File::files(storage_path('app/rag-data'));
    }
}
