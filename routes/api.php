<?php


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

Route::group(['namespace' => 'Frontend\Api', 'as' => 'frontend.api.'], __DIR__.'/frontend/api.php');

Route::group(['namespace' => 'Backend\Api', 'as' => 'backend.api.', 'prefix' => 'backend'], __DIR__.'/backend/api.php');
