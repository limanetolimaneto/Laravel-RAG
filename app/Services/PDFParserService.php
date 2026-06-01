<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use App\Services\DocumentParserInterface;

class PDFParserService implements DocumentParserInterface{
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
