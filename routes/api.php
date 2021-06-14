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


    Route::get('/categories', 'CategoryController@index');
    Route::get('/category/create', 'CategoryController@create');
    Route::post('/category/store', 'CategoryController@store'); //requires email to be sent
    Route::get('/category/edit/{id}', 'CategoryController@edit'); // with selected category id
    Route::put('/category/update/{id}', 'CategoryController@update'); // with selected category id
    Route::get('/category/delete/{id}', 'CategoryController@destroy');// with selected category id

    Route::get('/subcategories', 'SubcategoryController@index');
    Route::get('/subcategories/{id}', 'SubcategoryController@indexById'); // with selected category id
    Route::get('/subcategory/create', 'SubcategoryController@create');
    Route::post('/subcategory/store', 'SubcategoryController@store'); //requires email to be sent
    Route::get('/subcategory/show/{id}', 'SubcategoryController@show');// with selected subcategory id
    Route::get('/subcategory/edit/{id}', 'SubcategoryController@edit'); // with selected subcategory id
    Route::put('/subcategory/update/{id}', 'SubcategoryController@update'); // with selected subcategory id
    Route::get('/subcategory/delete/{id}', 'SubcategoryController@destroy'); // with selected subcategory id

});



