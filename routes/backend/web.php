<?php

Route::get('/backend/{path?}', 'DashboardController@index')->where('path', '[\/\w\.-]*')->name('dashboard');
