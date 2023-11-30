<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/users',[UserController::class, 'register']);
Route::post('/users/login',[UserController::class, 'login']);


Route::get('/authors',[AuthorController::class, 'get']);
Route::post('/authors',[AuthorController::class, 'store']);
Route::put('/authors/{id}',[AuthorController::class, 'update'])->where('id', '[0-9]+');
Route::delete('/authors/{id}',[AuthorController::class,'delete'])->where('id', '[0-9]+');


Route::post('/books',[BookController::class,'store']);
Route::get('/books',[BookController::class, 'search']);
Route::get('/books/{id}',[BookController::class, 'get'])->where('id', '[0-9]+');
Route::put('/books/{id}',[BookController::class, 'update'])->where('id', '[0-9]+');
Route::delete('/books/{id}',[BookController::class, 'delete'])->where('id', '[0-9]+');



