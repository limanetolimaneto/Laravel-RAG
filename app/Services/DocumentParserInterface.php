<?php

namespace App\Services;

/**
 * Contract that defines how document parsers must behave.
 * Every parser implementation must return raw text content
 * from a given file path.
*/
interface DocumentParserInterface
{
    /**
     * Extract text content from a document.
     *
     * @param string $path Path to the document file
     * @return string Extracted raw text
    */
    public function parse(string $path):string;
}
