<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/registrar', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::apiResource('disciplinas', DisciplineController::class);
    Route::apiResource('notas', GradeController::class);
});
