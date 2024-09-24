<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CSVImportController;
use App\Http\Controllers\UpdateController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/get_otp', [AuthController::class, 'generate_otp']);

Route::post('/login/{id?}', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/fetch_user', [ViewController::class, 'users']);
    Route::get('/fetch_sector', [ViewController::class, 'sector']);
    Route::get('/fetch_subsector', [ViewController::class, 'subsectors']);
    Route::post('/get_hof', [ViewController::class, 'fetch_by_hof']);
    Route::post('/get_hof_details', [ViewController::class, 'hof_details']);


    Route::post('/update_hof_details/{id}', [UpdateController::class, 'update_record']);

    Route::post('/import_users', [CSVImportController::class, 'importUser']);
});
Route::get('/import_users', [CSVImportController::class, 'importUser']);
