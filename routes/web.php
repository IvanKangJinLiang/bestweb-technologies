<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 

Route::get('/', function () {
    return redirect()->route('users.index'); 
});

// 1. Custom Routes
Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk_delete');
Route::get('users-export', [UserController::class, 'export'])->name('users.export');

// 2. Resource Route 
Route::resource('users', UserController::class);