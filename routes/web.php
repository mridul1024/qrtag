<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/create', 'UserController@create')->name('users-create');
    Route::post('/users/store', 'UserController@store')->name('users-store');
    Route::get('/users/{user}/edit', 'UserController@edit');
    Route::put('/user/update/{id}', 'UserController@update');
    Route::get('/user/delete/{id}', 'UserController@destroy');
    Route::get('/user/show/{id}', 'UserController@show');
});

