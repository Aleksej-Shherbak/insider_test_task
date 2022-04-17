<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\TeamController;
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

Route::get('/teams', [TeamController::class, 'all']);
Route::post('/calculate-fixtures', [FixtureController::class, 'calculateFixtures']);
Route::post('/get-forecast', [ForecastController::class, 'getForecast']);
