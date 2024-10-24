<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MumeneenController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CSVImportController;
use App\Http\Controllers\UpdateController;

Route::post('/register', [MumeneenController::class, 'register_users']);

Route::post('/get_otp', [AuthController::class, 'generate_otp']);

Route::post('/login/{id?}', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/import_users', [CSVImportController::class, 'importUser']);

    // user
    Route::get('/user', [MumeneenController::class, 'users']);
    Route::post('/update_user/{id}', [MumeneenController::class, 'update_record']);
    Route::delete('/user/{id}', [MumeneenController::class, 'delete_user']);

    // its
    Route::post('/its', [MumeneenController::class, 'register_its']);
    Route::get('/its', [MumeneenController::class, 'all_its']);
    Route::post('/update_its/{id}', [MumeneenController::class, 'update_its']);
    Route::delete('/its/{id}', [MumeneenController::class, 'delete_its']);
    
    // sector
    Route::post('/sector', [MumeneenController::class, 'register_sector']);
    Route::get('/sector', [MumeneenController::class, 'all_sector']);
    Route::post('/update_sector/{id}', [MumeneenController::class, 'update_sector']);
    Route::delete('/sector/{id}', [MumeneenController::class, 'delete_sector']);

    // sub-sector
    Route::post('/sub_sector', [MumeneenController::class, 'register_sub_sector']);
    Route::get('/sub_sector', [MumeneenController::class, 'all_sub_sector']);
    Route::post('/update_sub_sector/{id}', [MumeneenController::class, 'update_sub_sector']);
    Route::delete('/sub_sector/{id}', [MumeneenController::class, 'delete_sub_sector']);

    // building
    Route::post('/building', [MumeneenController::class, 'register_building']);
    Route::get('/building', [MumeneenController::class, 'all_building']);
    Route::post('/update_building/{id}', [MumeneenController::class, 'update_building']);
    Route::delete('/building/{id}', [MumeneenController::class, 'delete_building']);

    // year
    Route::post('/year', [MumeneenController::class, 'register_year']);
    Route::get('/year', [MumeneenController::class, 'all_year']);
    Route::post('/update_year/{id}', [MumeneenController::class, 'update_year']);
    Route::delete('/year/{id}', [MumeneenController::class, 'delete_year']);

    // menu
    Route::post('/menu', [MumeneenController::class, 'register_menu']);
    Route::get('/menu', [MumeneenController::class, 'all_menu']);
    Route::post('/update_menu/{id}', [MumeneenController::class, 'update_menu']);
    Route::delete('/menu/{id}', [MumeneenController::class, 'delete_menu']);
    
    // fcm
    Route::post('/fcm', [MumeneenController::class, 'register_fcm']);
    Route::get('/fcm', [MumeneenController::class, 'all_fcm']);
    Route::post('/update_fcm/{id}', [MumeneenController::class, 'update_fcm']);
    Route::delete('/fcm/{id}', [MumeneenController::class, 'delete_fcm']);

    // hub
    Route::post('/hub', [MumeneenController::class, 'register_hub']);
    Route::get('/hub', [MumeneenController::class, 'all_hub']);
    Route::post('/update_hub/{id}', [MumeneenController::class, 'update_hub']);
    Route::delete('/hub/{id}', [MumeneenController::class, 'delete_fcm']);

    // zabihat
    Route::post('/zabihat', [MumeneenController::class, 'register_zabihat']);
    Route::get('/zabihat', [MumeneenController::class, 'all_zabihat']);
    Route::post('/update_zabihat/{id}', [MumeneenController::class, 'update_zabihat']);
    Route::delete('/zabihat/{id}', [MumeneenController::class, 'delete_zabihat']);
    
    // counter
    Route::post('/counter', [AccountsController::class, 'register_counter']);
    Route::get('/counter', [AccountsController::class, 'all_counter']);
    Route::post('/update_counter/{id}', [AccountsController::class, 'update_counter']);
    Route::delete('/counter/{id}', [AccountsController::class, 'delete_counter']);
    
    // advance_receipt
    Route::post('/advance_receipt', [AccountsController::class, 'register_advance_receipt']);
    Route::get('/advance_receipt', [AccountsController::class, 'all_advance_receipt']);
    Route::post('/update_advance_receipt/{id}', [AccountsController::class, 'update_advance_receipt']);
    Route::delete('/advance_receipt/{id}', [AccountsController::class, 'delete_advance_receipt']);
    
    // expense
    Route::post('/expense', [AccountsController::class, 'register_expense']);
    Route::get('/expense', [AccountsController::class, 'all_expense']);
    Route::post('/update_expense/{id}', [AccountsController::class, 'update_expense']);
    Route::delete('/expense/{id}', [AccountsController::class, 'delete_expense']);
    
    // payments
    Route::post('/payments', [AccountsController::class, 'register_payments']);
    Route::get('/payments', [AccountsController::class, 'all_payments']);
    Route::post('/update_payments/{id}', [AccountsController::class, 'update_payments']);
    Route::delete('/payments/{id}', [AccountsController::class, 'delete_payments']);

    // receipts
    Route::post('/receipts', [AccountsController::class, 'register_receipts']);
    Route::get('/receipts', [AccountsController::class, 'all_receipts']);
    Route::post('/update_receipts/{id}', [AccountsController::class, 'update_receipts']);
    Route::delete('/receipts/{id}', [AccountsController::class, 'delete_receipts']);

    // vendors
    Route::post('/vendors', [InventoryController::class, 'register_vendors']);
    Route::get('/vendors', [InventoryController::class, 'all_vendors']);
    Route::post('/update_vendors/{id}', [InventoryController::class, 'update_vendors']);
    Route::delete('/vendors/{id}', [InventoryController::class, 'delete_vendors']);

    // food_items
    Route::post('/food_items', [InventoryController::class, 'register_food_items']);
    Route::get('/food_items', [InventoryController::class, 'all_food_items']);
    Route::post('/update_food_items/{id}', [InventoryController::class, 'update_food_items']);
    Route::delete('/food_items/{id}', [InventoryController::class, 'delete_food_items']);

    // food_purchase
    Route::post('/food_purchase', [InventoryController::class, 'register_food_purchase']);
    Route::get('/food_purchase', [InventoryController::class, 'all_food_purchase']);
    Route::post('/update_food_purchase/{id}', [InventoryController::class, 'update_food_purchase']);
    Route::delete('/food_purchase/{id}', [InventoryController::class, 'delete_food_purchase']);

    // food_sale
    Route::post('/food_sale', [InventoryController::class, 'register_food_sale']);
    Route::get('/food_sale', [InventoryController::class, 'all_food_sale']);
    Route::post('/update_food_sale/{id}', [InventoryController::class, 'update_food_sale']);
    Route::delete('/food_sale/{id}', [InventoryController::class, 'delete_food_sale']);
    
    // damage_lost
    Route::post('/damage_lost', [InventoryController::class, 'register_damage_lost']);
    Route::get('/damage_lost', [InventoryController::class, 'all_damage_lost']);
    Route::post('/update_damage_lost/{id}', [InventoryController::class, 'update_damage_lost']);
    Route::delete('/damage_lost/{id}', [InventoryController::class, 'delete_damage_lost']);
    
    // food_purchase_items
    Route::post('/food_purchase_items', [InventoryController::class, 'register_food_purchase_items']);
    Route::get('/food_purchase_items', [InventoryController::class, 'all_food_purchase_items']);
    Route::post('/update_food_purchase_items/{id}', [InventoryController::class, 'update_food_purchase_items']);
    Route::delete('/food_purchase_items/{id}', [InventoryController::class, 'delete_food_purchase_items']);
    
    // food_sale_items
    Route::post('/food_sale_items', [InventoryController::class, 'register_food_sale_items']);
    Route::get('/food_sale_items', [InventoryController::class, 'all_food_sale_items']);
    Route::post('/update_food_sale_items/{id}', [InventoryController::class, 'update_food_sale_items']);
    Route::delete('/food_sale_items/{id}', [InventoryController::class, 'delete_food_sale_items']);
    
});
Route::get('/import_users', [CSVImportController::class, 'importUser']);
