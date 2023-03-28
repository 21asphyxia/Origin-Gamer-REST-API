<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Auth
Route::controller(AuthController::class)->group(function () {
    // middleware guest group
    Route::middleware('guest')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('forgot-password', 'forgotPassword')->name('password.email');
        Route::post('reset-password', 'resetPassword')->name('password.update');
        Route::get('reset-password/{token}', function (string $token) {
            return $token;
        })->middleware('guest')->name('password.reset');   
    });
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

// Roles
Route::controller(RoleController::class)->group(function () {
    Route::prefix('roles')->group(function () {
        Route::get('/', 'index')->middleware('can:read roles');
        Route::post('/{role}/permissions', 'assignPermissionsToRole')->middleware('can:assign permissions');
        Route::delete('/{role}/permissions', 'revokePermissionsFromRole')->middleware('can:revoke permissions');
    });
});

// Permissions
Route::get('permissions', [PermissionController::class, 'index'])->middleware('can:read permissions');

// Role assignments and profile update
Route::controller(UserController::class)->group(function () {
    Route::post('profile', 'updateProfile')->middleware('auth:api');
    
    Route::prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::post('/{user}/roles', 'assignRoleToUser')->middleware('can:assign roles');
        Route::delete('/{user}/roles', 'revokeRoleFromUser')->middleware('can:revoke roles');
    });
});

// Products
Route::controller(ProductController::class)->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', 'index')->middleware('can:read products');
        Route::get('/{product}', 'show')->middleware('can:read products');
        // Route::get('/filter?category={category}', 'filterByCategory')->middleware('can:read products');
        Route::post('/', 'store')->middleware('can:create products');
        Route::put('/{product}', 'update')->middleware('permission:update all products|update own products');
        Route::delete('/{product}', 'destroy')->middleware('permission:delete all products|delete own products');
    });
});

// Categories
Route::controller(CategoryController::class)->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', 'index')->middleware('can:read categories');
        Route::get('/{category}', 'show')->middleware('can:read categories');
        Route::post('/', 'store')->middleware('can:create categories');
        Route::put('/{category}', 'update')->middleware('can:update categories');
        Route::delete('/{category}', 'destroy')->middleware('can:delete categories');
    });
});