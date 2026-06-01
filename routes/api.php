<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentIngestionController;
use App\Http\Controllers\AIController;

Route::get('/ai-db-embedding', [DocumentIngestionController::class, 'ingest']);
Route::get('/ai-search', [AIController::class, 'search']);
Route::get('/ai-chat', [AIController::class, 'chat']);