<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class DocumentListService
{
    // O codigo: 
    // ===============
    // protected $list;
    // private function setList(){
    //     $this->list = File::files(storage_path('app'));
    // }
    // public function list(){
    //     $this->setList();
    //     return $this->list;
    // }
    // ===============
    // Pode ser resumido por:
    public function list(): array
    {
        return File::files(storage_path('app/rag-data'));
    }
}
