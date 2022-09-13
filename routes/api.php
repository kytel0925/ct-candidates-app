<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

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


Route::prefix('/tasks')->group(function(){
    Route::get('index', [TasksController::class, 'index']);
    Route::post('store', [TasksController::class, 'create']);
    Route::put('update', [TasksController::class, 'update']);
    Route::put('change-status/{id}', [TasksController::class, 'changeStatus']);
    Route::delete('delete/{id}', [TasksController::class, 'destroy']);
});