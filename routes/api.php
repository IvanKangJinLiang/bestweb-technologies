<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController; 

// This single line creates all 5 API endpoints (Index, Store, Show, Update, Destroy)
Route::apiResource('users', UserController::class)->names('api.users');

// Add your custom bulk delete route
Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete']);