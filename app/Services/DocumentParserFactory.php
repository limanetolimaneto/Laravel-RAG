<?php

namespace App\Services;

use App\Services\DocumentParserInterface;

/**
 * Factory responsible for selecting the correct document parser
 * based on the file extension.
*/
class DocumentParserFactory
{
    /**
     * Resolve and return the appropriate parser implementation
     * for the given file path.
     *
     * @param string $path Full file path or filename
     * @return DocumentParserInterface
     *
     * @throws \Exception If the file format is not supported
    */
    public function make(string $path): DocumentParserInterface
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return match ($extension) {
            'txt' => resolve(TXTParserService::class),
            'pdf' => resolve(PDFParserService::class),
            default => throw new \Exception('Formato não suportado')
        };
    }
}
