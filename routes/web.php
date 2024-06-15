<?php

use App\Http\Controllers\{
    AuthController,
    PermissionController,
    RoleController,
    UserController,
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
    Route::get('/role', [RoleController::class, 'index'])->name('manage-role');
    Route::post('/create-role', [RoleController::class, 'createRole'])->name('create-role');
    Route::post('/update-role', [RoleController::class, 'updateRole'])->name('update-role');
    Route::post('/delete-role', [RoleController::class, 'deleteRole'])->name('delete-role');

    // Permission Routes
    Route::get('/permission', [PermissionController::class, 'index'])->name('manage-permission');
    Route::post('/create-permission', [PermissionController::class, 'createPermission'])->name('create-permission');
    Route::post('/update-permission', [PermissionController::class, 'updatePermission'])->name('update-permission');
    Route::post('/delete-permission', [PermissionController::class, 'deletePermission'])->name('delete-permission');

    // Assign permission role
    Route::get('/assign-permission-role', [PermissionController::class, 'assignPermissionRole'])->name('assign-permission-role');
    Route::post('/create-permission-role', [PermissionController::class, 'createPermissionRole'])->name('create-permission-role');
    Route::post('/update-permission-role', [PermissionController::class, 'updatePermissionRole'])->name('update-permission-role');
    Route::post('/delete-permission-role', [PermissionController::class, 'deletePermissionRole'])->name('delete-permission-role');

    // Assign permission routes
    Route::get('/assign-permission-route', [PermissionController::class, 'assignPermissionRoute'])->name('assign-permission-route');
    Route::post('/create-permission-route', [PermissionController::class, 'createPermissionRoute'])->name('create-permission-route');
    Route::post('/update-permission-route', [PermissionController::class, 'updatePermissionRoute'])->name('update-permission-route');
    Route::post('/delete-permission-route', [PermissionController::class, 'deletePermissionRoute'])->name('delete-permission-route');

    // Assign users routes
    Route::get('/manage-user', [UserController::class, 'manageUser'])->name('manage-user');
    Route::post('/create-user', [UserController::class, 'createUser'])->name('create-user');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('update-user');
    Route::post('/delete-user', [UserController::class, 'deleteUser'])->name('delete-user');
});
