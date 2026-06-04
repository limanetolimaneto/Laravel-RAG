<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentIngestionController;
use App\Http\Controllers\AIController;

Route::post('/ai-db-embedding', [DocumentIngestionController::class, 'ingest']);
Route::post('/ai-search', [AIController::class, 'search']);
Route::post('/ai-chat', [AIController::class, 'chat']);


