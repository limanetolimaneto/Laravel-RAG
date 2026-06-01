<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Embedding extends Model{
    protected $table = "embeddings";
    protected $fillable = [
        'document_name',
        'content',
        'embedding',
        'chunk_index',
    ]; 
    protected function casts(): array
    {
        return [
            'embedding' => 'array', // Transforma o array PHP em JSON no banco e vice-versa
        ];
    }
}
