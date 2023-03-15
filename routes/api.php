<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('feedback', [ApiController::class, 'feedback'])->name('api.feedback');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('log', [ApiController::class, 'log'])->name('exceptions.log');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
