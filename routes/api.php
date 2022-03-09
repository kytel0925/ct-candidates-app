<?php

use App\Http\Controllers\TodoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/todos', [TodoController::class, 'index'])->name('todo.list');
    Route::get('/todo/complete/{todo}', [TodoController::class, 'markComplete'])->name('todo.markComplete');
    Route::post('/todo/reorder', [TodoController::class, 'reorder'])->name('todo.reorder');
    Route::post('/todo/save', [TodoController::class, 'store'])->name('todo.store');
    Route::post('/todo/remove', [TodoController::class, 'remove'])->name('todo.remove');

    Route::post('/user', [UserController::class, 'store'])->name('user.save');
});