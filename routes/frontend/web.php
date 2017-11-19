<?php

Route::middleware('record_visitor')->group(function (){

    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/categories/{slug}', 'CategoriesController@show')->name('category.show');

    Route::get('/posts/{slug}', 'PostsController@show')->name('post.show');

    Route::get('search', 'PostsController@search')->name('search');
});
