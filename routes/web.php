<?php

use App\Http\Controllers\{
    AuthController,
    PermissionController,
    RoleController,
};
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('load.login');
    Route::get('/register', 'loadRegister')->name('load.register');
    Route::post('/post-register', 'postRegister')->name('post.register');
    Route::post('/post-login', 'postLogin')->name('post.login');
})->middleware('guest');

Route::middleware('isAuthenticated')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashBoard'])->name('auth.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    // Role Routes
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/create-role', [RoleController::class, 'createRole'])->name('create.role');
    // Route::get('/fetch-role', [RoleController::class, 'fetchRole'])->name('fetch.role');
    Route::post('/update-role', [RoleController::class, 'updateRole'])->name('update.role');
    Route::post('/delete-role', [RoleController::class, 'deleteRole'])->name('delete.role');

    // Permission Routes
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('/create-permission', [PermissionController::class, 'createPermission'])->name('create.permission');
    // Route::get('/fetch-permission', [PermissionController::class, 'fetchPermission'])->name('fetch.permission');
    Route::post('/update-permission', [PermissionController::class, 'updatePermission'])->name('update.permission');
    Route::post('/delete-permission', [PermissionController::class, 'deletePermission'])->name('delete.permission');

    // Assign permission role
    Route::get('/assign-permission-role', [PermissionController::class, 'assignPermissionRole'])->name('assign.permission.role');
    Route::post('/create-permission-role', [PermissionController::class, 'createPermissionRole'])->name('create.permission.role');
    Route::get('/fetch-permission-role', [PermissionController::class, 'fetchPermissionRole'])->name('fetch.permission.role');
    Route::post('/update-permission-role', [PermissionController::class, 'updatePermissionRole'])->name('update.permission.role');
    Route::post('/delete-permission-role', [PermissionController::class, 'deletePermissionRole'])->name('delete.permission.role');
});
