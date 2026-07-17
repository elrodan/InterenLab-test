<?php

use App\Http\Controllers\Api\SystemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/health', [SystemController::class, 'health']);
Route::get('/metrics', [SystemController::class, 'metrics']);