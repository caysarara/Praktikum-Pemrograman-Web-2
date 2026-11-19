<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TechnologyController;

Route::middleware('throttle:portfolio-api')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/technologies', [TechnologyController::class, 'index']);
});
