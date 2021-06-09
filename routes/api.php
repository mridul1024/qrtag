<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//Route::get('users/update/{id}', 'UserController@update');

//public
Route::get('login', 'AuthApiController@login')->name('login');

//protected routes user management
Route::group(['middleware' => ['auth:sanctum']], function () {

    // http://127.0.0.1:8000/api/logout/?email=admin@admin.com
    Route::get('logout', 'AuthApiController@logout'); // requires email of the user
    // http://127.0.0.1:8000/api/users/?email=admin@admin.com
    Route::get('/users', 'UserController@index');  //requires email of the user
    // http://127.0.0.1:8000/api/users/roles/?email=admin@admin.com
    Route::get('/users/roles', 'UserController@create'); //requires email of the user
    // http://127.0.0.1:8000/api/users/store
    Route::post('/users/store', 'UserController@store');

    //http://127.0.0.1:8000/api/users/edit/1/?email=admin@admin.com example response ?email=value is the request part
    Route::get('/users/edit/{id}', 'UserController@edit');
    // http://127.0.0.1:8000/api/user/show/2
    Route::get('/user/show/{id}', 'UserController@show');
    //http://127.0.0.1:8000/api/user/update/7?name=babu&email=adminweb@adminweb.com&role=3  where 7 is the user id
    Route::put('/user/update/{id}', 'UserController@update');
    //http://127.0.0.1:8000/api/user/delete/7
    Route::get('/user/delete/{id}', 'UserController@destroy');
});



