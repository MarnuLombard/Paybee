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

Auth::routes();

Route::get('/', 'IndexController')
    ->name('index');
Route::get('/home', 'UserController@edit')
    ->name('users.edit');
Route::patch('/home', 'UserController@update')
    ->name('users.update');
