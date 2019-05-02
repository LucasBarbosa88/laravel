<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('users', 'UserController@pagination')->name('pagination.users');
Route::get('products', 'ProductController@pagination')->name('pagination.products');
Route::get('orders', 'OrderController@pagination')->name('pagination.orders');
