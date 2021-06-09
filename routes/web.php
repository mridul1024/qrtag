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

    Route::get('/categories', 'CategoryController@index')->name('categories');

    Route::get('/category/create', 'CategoryController@create');
    Route::post('/category/store', 'CategoryController@store')->name('category-store');

    Route::get('/subcategories', 'SubcategoryController@index')->name('subcategories');
    Route::get('/subcategories/{id}', 'SubcategoryController@indexById');
    Route::get('/subcategory/create', 'SubcategoryController@create');
    Route::post('/subcategory/store', 'SubcategoryController@store')->name('subcategory-store');
    Route::get('/subcategory/show/{id}', 'SubcategoryController@show');


    Route::get('/subcategorytypes/{id}', 'SubcategorytypeController@index')->name('subcategorytypes');
    Route::get('/subcategorytype/create/{id}', 'SubcategorytypeController@create');
    Route::post('/subcategorytype/store', 'SubcategorytypeController@store')->name('subcategorytype-store');
    Route::get('/subcategorytype/show/{id}', 'SubcategorytypeController@show');
    Route::put('/subcategorytype/generateQr', 'SubcategorytypeController@generateQr');

    Route::get('/attributes', 'AttributesController@index')->name('attributes');
    Route::get('/attribute/create', 'AttributesController@create')->name('attribute-create');
    Route::post('/attribute/store', 'AttributesController@store')->name('attribute-store');
    Route::get('/attribute/create/{id}', 'AttributesController@create');

    Route::get('/attributemaster/create', 'AttributeMasterController@create')->name('attributemaster-create');
    Route::get('/attributemasters', 'AttributeMasterController@index')->name('attributemasters');
    Route::post('/attributemaster/store', 'AttributeMasterController@store')->name('attributemaster-store');

});

