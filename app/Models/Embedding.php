<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model representing stored vector embeddings generated from document chunks.
*/
class Embedding extends Model{
    /**
     * Database table used by this model.
    */
    protected $table = "embeddings";
    
    /**
     * Attributes that are mass assignable.
    */
    protected $fillable = [
        'document_name',
        'content',
        'embedding',
        'chunk_index',
    ]; 
    
    /**
     * Attribute casting configuration.
     * Ensures embeddings are automatically converted to/from array format.
     *
     * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'embedding' => 'array', 
        ];
    }
}
