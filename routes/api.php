<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\EnsureTokenIsValid;
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

Route::post('login', [ApiController::class, 'login']); //new
/* Route::get('tasks', [EnsureTokenIsValid::class, 'tasks'])
    ->middleware(ApiController::class);
 */
Route::group(['middleware' => 'apiList'], function ($router) {
    Route::get('/tasks', [ApiController::class, 'tasks']);
    Route::post('/tasks', [ApiController::class, 'tasks_create']);
    Route::get('/employees', [ApiController::class, 'employees']);
    Route::get('/projects', [ApiController::class, 'projects']);
});
Route::group(['middleware' => 'apiObject'], function ($router) {
    Route::post('/tasks', [ApiController::class, 'tasks_create']);
});


/* Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/register', [ApiController::class, 'register']);
    Route::post('/login', [ApiController::class, 'login']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::post('/profile', [ApiController::class, 'profile']);
});
 */