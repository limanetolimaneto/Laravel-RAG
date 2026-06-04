<?php

namespace App\Services;

use App\Services\DocumentParserInterface;

/**
 * Parser responsible for extracting text from plain TXT files.
*/
class TXTParserService implements DocumentParserInterface{

    /**
     * Read and return the raw content of a TXT file.
     *
     * @param string $path Path to the TXT file
     * @return string File contents
     *
     * @throws \Exception If the file does not exist
    */
    public function parse(string $path): string
    {
        if (! file_exists($path)) {
            throw new \Exception("Arquivo não encontrado.");
        }

        return file_get_contents($path);
    }
}
