<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StaticFilesController;

/*
Route::prefix('/download')->group(function () {
    Route::prefix('/references')->group(function () {
        Route::get('/regions', [StaticFilesController::class, '']);
        Route::get('/municipalities', [StaticFilesController::class, '']);
        Route::get('/accesses', [StaticFilesController::class, '']);
        Route::get('/terrains', [StaticFilesController::class, '']);
        Route::get('/volumes', [StaticFilesController::class, '']);
        Route::get('/irsops', [StaticFilesController::class, '']);
    });
    Route::get('/dump', [StaticFilesController::class, 'export']);
});
*/

Route::get('/test', [TestController::class, 'index']);
