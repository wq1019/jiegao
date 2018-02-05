<?php

// Route::get('auth/captcha_src', 'Auth\LoginController@captchaSrc');
Route::get('auth/need_verification_code', 'Auth\LoginController@needVerificationCodeRequest');
Route::post('auth/login', 'Auth\LoginController@login');
Route::post('auth/logout', 'Auth\LoginController@logout');

Route::post('ajax_upload_image', 'ImageController@upload');

Route::resource('users', 'UsersController', [
    'except'=> ['create', 'edit'],
]);

Route::get('me', 'UsersController@me');

// 获取所有角色(不分页 用于添加用户时显示)
Route::get('roles/all', 'RolesController@allRoles');
Route::resource('roles', 'RolesController', [
    'except'=> ['create', 'edit'],
]);

Route::get('roles/{role}/permissions', 'RolesController@permissions');

Route::resource('posts', 'PostsController', [
    'except'=> ['create', 'edit'],
]);
// 真删除指定的文章
Route::delete('posts/{post}/real', 'PostsController@realDestroy');
// 恢复指定的被软删除的文章
Route::post('posts/{post}/restore', 'PostsController@restore');
// 获取模板
Route::get('templates', 'TemplatesController@templates');

Route::get('categories/visual_output', 'CategoriesController@visualOutput');
Route::resource('categories', 'CategoriesController', [
    'except'=> ['create', 'edit'],
]);

// 获取单页
Route::get('categories/{category}/page', 'CategoriesController@page');
// 创建或更新单页
Route::post('categories/{category}/page', 'CategoriesController@savePage');
Route::resource('banners', 'BannersController', [
    'except'=> ['create', 'edit'],
]);

Route::resource('links', 'LinksController', [
    'except'=> ['create', 'edit'],
]);

Route::post('settings/index_order', 'SettingsController@setOrder');
Route::resource('settings', 'SettingsController', [
    'except'=> ['create', 'edit'],
]);

Route::resource('types', 'TypesController', [
    'except' => ['create', 'edit'],
]);

// 获取统计数据
Route::get('statistics', 'HomeController@index');

Route::resource('attachments', 'AttachmentsController', [
    'except'=> ['create', 'edit'],
]);

Route::resource('tags', 'TagsController', [
    'except'=> ['create', 'edit'],
]);
