<?php
/**
 * Authenticated routes
 * Middleware 'auth'
 */

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('products', 'ProductController');
