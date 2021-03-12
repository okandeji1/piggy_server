<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\FundController;


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

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class,'logout']);
    // Other controllers
    Route::post('/complete-registration', [PersonalController::class, 'store']);
    Route::post('/add-fund', [FundController::class, 'store']);
    // Route::post('/upload', [FundController::class, 'upload']);
    Route::get('/get-investments', [InvestmentController::class, 'show']);

});