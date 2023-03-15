<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

// group all routes of role with prefix (roles)
Route::controller(RoleController::class)->group(function () {
    Route::prefix('roles')->group(function () {
        Route::get('/', 'index');
        Route::post('/{role}/permissions', 'assignPermissionsToRole');
        Route::delete('/{role}/permissions', 'revokePermissionsFromRole');
    });
});

Route::get('permissions', [PermissionController::class, 'index']);


Route::apiResource('products', ProductController::class);

Route::apiResource('categories', CategoryController::class);