<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});
Route::group(['prefix'=>'openjob'],function($router){
    Route::get('get/{id}', [openJobController::class, 'index']);
    Route::post('create', [openJobController::class, 'create']);
    Route::post('update/{id}', [openJobController::class, 'update']);
    Route::post('destroy/{id}', [openJobController::class, 'destroy']);
    
});
Route::group(['prefix'=>'certificate'],function($router){
    Route::get('get/{id}', [certificateController::class, 'index']);
    Route::post('create', [certificateController::class, 'create']);
    Route::post('update/{id}', [certificateController::class, 'update']);
    Route::post('destroy/{id}', [certificateController::class, 'destroy']);
});
// Route::group(['prefix'=>''],function($router){

// });
