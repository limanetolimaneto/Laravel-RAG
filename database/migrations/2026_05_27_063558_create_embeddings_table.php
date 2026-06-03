<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('embeddings', function (Blueprint $table) {
            $table->id();
            $table->string('document_name');
            $table->longText('content');
            // Embedding field based on Mysql version
            // json <= '8.4.0' >= vector
            $pdo = DB::connection()->getPdo();
            $version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
            if (version_compare($version, '8.4.0', '>=')) {
                $table->raw('embedding VECTOR(768) NOT NULL');
            } else {
                $table->json('embedding');
            }
            $table->integer('chunk_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
