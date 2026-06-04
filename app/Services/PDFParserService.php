<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use App\Services\DocumentParserInterface;

/**
 * Parser responsible for extracting text content from PDF files.
 * Uses Smalot PDF Parser library.
*/
class PDFParserService implements DocumentParserInterface{

    /**
     * Extract text content from a PDF file.
     *
     * @param string $path Path to the PDF file
     * @return string Extracted text
     *
     * @throws \Exception If the file does not exist
    */
    public function parse(string $path): string
    {
        if (! file_exists($path)) {
            throw new \Exception('Arquivo não encontrado.');
        }

        $parser = new Parser();

        $pdf = $parser->parseFile($path);

        return $pdf->getText();
    }
}
