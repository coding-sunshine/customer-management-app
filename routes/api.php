<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CategoryController;

/*Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('categories', CategoryController::class)->only(['index']);
});*/
Route::middleware([])->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('categories', CategoryController::class)->only(['index']);
});
