<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Frontend\Web', 'as' => 'frontend.web.'], __DIR__.'/frontend/web.php');

Route::group(['namespace' => 'Backend\Web', 'as' => 'backend.web.'], __DIR__.'/backend/web.php');
