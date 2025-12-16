<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 

Route::get('/', function () {
    return redirect()->route('users.index'); 
});

//Custom Routes
Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk_delete');
Route::get('users-export', [UserController::class, 'export'])->name('users.export');

//5 API endpoints (Index, Store, Show, Update, Destroy)
Route::resource('users', UserController::class);