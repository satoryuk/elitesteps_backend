<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\Auth\AdminAuthController;
use App\Http\Controllers\api\v1\Admin\UserController;
use App\Http\Controllers\api\v1\Admin\BrandController;
use App\Http\Controllers\api\v1\Admin\CategoryController;
use App\Http\Controllers\api\v1\Admin\ProductController;
use App\Http\Controllers\api\v1\Admin\TypeController;
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

    // Type Routes
    Route::get('/types', [TypeController::class, 'index']);
    Route::post('/types', [TypeController::class, 'store']);
    Route::get('/types/{id}', [TypeController::class, 'getTypeById']);
    Route::put('/types/{id}', [TypeController::class, 'updateType']);
    Route::delete('/types/{id}', [TypeController::class, 'deleteType']);
    
    // Brand Routes
    Route::get('/brands', [BrandController::class, 'index']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands/{id}', [BrandController::class, 'getBrandById']);
    Route::put('/brands/{id}', [BrandController::class, 'updateBrand']);
    Route::delete('/brands/{id}', [BrandController::class, 'deleteBrand']);

    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'getCategoryById']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

    // Product Routes
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'getProductById']);
    Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
    Route::patch('/products/{id}/deactivate', [ProductController::class, 'deactivateProduct']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
});