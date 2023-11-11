<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/items', [TodoController::class, 'index']);
Route::get('/items/{id}', [TodoController::class, 'indexById']);
Route::post('/items', [TodoController::class, 'store']);
Route::put('/items/{id}', [TodoController::class, 'update']);
Route::delete('/items/{id}', [TodoController::class, 'destroy']);
