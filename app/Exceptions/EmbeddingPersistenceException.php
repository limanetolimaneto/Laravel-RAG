<?php

namespace App\Exceptions;

use Exception;

class EmbeddingPersistenceException extends Exception
{
    public function __construct(protected String $info) {
        Log::info($this->info);
    }
}