<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------------------------- Product Routes ------------------------
Route::get('/products',[ProductController::class, 'get_all']);

Route::post('/product/create',[ProductController::class, 'create']);
Route::post('/product/show/{id}',[ProductController::class, 'show']);
Route::post('/product/show2',[ProductController::class, 'show_2']);
Route::post('/product/update/{id}',[ProductController::class, 'update']);
Route::post('/product/apdate', [ProductController::class, 'apdate']);
Route::delete('/product/delete', [ProductController::class, 'delete']);



// ------------------------- User Routes ------------------------
Route::post('/user/store', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/show/{id}', [UserController::class, 'show']);




// ------------------------- Api Routes ------------------------
Route::post('/user/login', [UserController::class, 'login']);
