<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentListService;
use App\Services\JobDispatchService;
use App\Exceptions\DocumentListException;

class DocumentIngestionController extends Controller
{
    /**
     * Controller responsible for triggering the document ingestion process.
     * It retrieves available documents and dispatches them to background jobs.
    */
    public function __construct(protected DocumentListService $list, protected JobDispatchService $dispatch) {}

    /**
     * Start the ingestion workflow:
     * 1. Retrieve the list of documents
     * 2. Validate that documents exist
     * 3. Dispatch jobs for processing
     *
     * @throws DocumentListException If no documents are found
     * @throws \Exception If job dispatching fails
    */

    public function ingest(){
        $documentList = $this->list->list();
        if(empty($documentList)){
            throw new DocumentListException('No documents found for ingestion.');
        };
        $jobDispatched = $this->dispatch->dispatch($documentList);
        if(! $jobDispatched){
            throw new \Exception('Error dispatching job.');
        };
        return response()->json([
            'message' => 'Jobs dispatched successfully'
        ]);
    }
}

