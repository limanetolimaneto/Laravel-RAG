<?php

namespace App\Services;

use App\Jobs\IngestDocumentJob as JOB;

/**
 * Service responsible for dispatching document ingestion jobs
 * to the Laravel queue system.
*/
class JobDispatchService
{
    /**
     * Dispatch a queue job for each document found.
     *
     * @param array $documents List of SplFileInfo file objects
     * @return int Number of dispatched jobs
    */
    public function dispatch($documents){
        foreach ($documents as $item) {
            JOB::dispatch($item->getPathname());
        }
        return count($documents);
    }
}
