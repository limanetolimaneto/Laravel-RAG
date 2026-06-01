<?php

namespace App\Services;

interface DocumentParserInterface
{
    public function parse(string $path):string;
}
