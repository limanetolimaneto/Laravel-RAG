<?php

namespace App\Services;

use App\Jobs\IngestDocumentJob as JOB;

class JobDispatchService
{
    public function dispatch($documents){
        foreach ($documents as $item) {
            JOB::dispatch($item->getPathname());
        }
        return count($documents);
    }
}
