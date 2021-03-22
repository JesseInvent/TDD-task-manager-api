<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(

    [
        'prefix' => 'auth'
    ],

    function ($router) {

        Route::get('me', [AuthController::class, 'me']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
        
    }
);

Route::group (

    [
        'middleware' => 'auth:api',
    ], 
    
    function ($router) {

        // Route::apiResource('task', TaskController::class);
        Route::get('/task', [TaskController::class, 'index']);
        Route::post('/task', [TaskController::class, 'store']);
        Route::get('/task/{task}', [TaskController::class, 'show']);
        Route::patch('/task/{task}', [TaskController::class, 'update']);
        Route::delete('/task/{task}', [TaskController::class, 'destroy']);
        Route::get('/task/{task}/completed', [TaskController::class, 'getUserCompletedTasks']);
        Route::post('/task/{task}/completed', [TaskController::class, 'markAsCompleted']);
        Route::delete('/task/{task}/completed', [TaskController::class, 'markAsUnCompleted']);

    }

);

