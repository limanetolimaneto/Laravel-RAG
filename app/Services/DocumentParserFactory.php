<?php

namespace App\Services;

use App\Services\DocumentParserInterface;


class DocumentParserFactory
{

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
