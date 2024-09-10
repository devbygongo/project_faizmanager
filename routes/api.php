<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CSVImportController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/get_otp', [AuthController::class, 'generate_otp']);

Route::post('/login/{id?}', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/fetch_user', [ViewController::class, 'users']);
    Route::get('/fetch_sector', [ViewController::class, 'sector']);
    Route::get('/fetch_subsector', [ViewController::class, 'subsectors']);

    Route::post('/import_users', [CSVImportController::class, 'importUser']);
});