<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentListService;
use App\Services\JobDispatchService;
use App\Exceptions\DocumentListException;

class DocumentIngestionController extends Controller
{
    public function __construct(protected DocumentListService $list, protected JobDispatchService $dispatch) {}
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

