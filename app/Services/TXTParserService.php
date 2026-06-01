<?php

namespace App\Services;

use App\Services\DocumentParserInterface;

class TXTParserService implements DocumentParserInterface{
    public function parse(string $path): string
    {
        if (! file_exists($path)) {
            throw new \Exception("Arquivo não encontrado.");
        }

        return file_get_contents($path);
    }
}
