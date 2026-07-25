<?php

use App\Modules\Projects\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')->group(function (): void {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::get('/{project}', [ProjectController::class, 'show']);
    Route::put('/{project}', [ProjectController::class, 'update']);
    Route::patch('/{project}', [ProjectController::class, 'update']);
    Route::delete('/{project}', [ProjectController::class, 'destroy']);
});
