<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//User
Route::post('/users', [UserController::class, 'store']);


//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/refresh', [AuthController::class, 'refresh']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

//Products
// Route::apiResource('/products', ProductController::class);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/highlights', [ProductController::class, 'highlights']);
Route::put('/products/update-quantity', [ProductController::class, 'updateQuantity']);


Route::middleware('auth:api')->group(function () {
    Route::put('/cart/update', [CartController::class, 'update']);
});