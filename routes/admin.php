<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\Auth\AdminAuthController;
use App\Http\Controllers\api\v1\Admin\UserController;
use App\Http\Controllers\api\v1\Admin\BrandController;
use App\Models\Inventory;

/*///////////////////////////////////////////
*
*           PUBLIC API
*   
*/ //////////////////////////////////////////

Route::post('/register', [AdminAuthController::class,'register']);
Route::post('/login', [AdminAuthController::class, 'login']);

/*///////////////////////////////////////////
*
*           PRIVATE API
*
*   ///////////////////////////////////////*/

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth/v1'], function ($router) {
    Route::post('/refresh-token', [AdminAuthController::class,'refreshToken']);
    Route::post('/logout', [AdminAuthController::class,'logout']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::put('/users/{user_id}', [UserController::class, 'updateUser']);
    Route::patch('/users/{id}/deactivate', [UserController::class, 'deactivateUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    
    // Brand Routes
    Route::get('/brands', [BrandController::class, 'index']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands/{id}', [BrandController::class, 'getBrandById']);
    Route::put('/brands/{id}', [BrandController::class, 'updateBrand']);
    Route::delete('/brands/{id}', [BrandController::class, 'deleteBrand']);

});