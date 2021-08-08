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

Route::get('/test',function () {

    return view('jobs.products.test');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/product/show/{id}', 'ProductController@show');
Route::post('/product/material', 'ProductController@showMId');
Route::get('/job/show/{id}', 'JobController@show');

Route::middleware('auth')->group(function () {

    Route::group(['middleware' => ['role:super-admin|admin']], function () {
        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/users/create', 'UserController@create')->name('users-create');
        Route::post('/users/store', 'UserController@store')->name('users-store');
        Route::get('/users/{user}/edit', 'UserController@edit');
        Route::put('/user/update/{id}', 'UserController@update');
        Route::get('/user/delete/{id}', 'UserController@destroy');
        Route::get('/user/show/{id}', 'UserController@show');
    });
    Route::group(['middleware' => ['role:super-admin|admin']], function () {
        Route::get('/category/create', 'CategoryController@create');
        Route::post('/category/store', 'CategoryController@store')->name('category-store');
        Route::get('/category/edit/{id}', 'CategoryController@edit');
        Route::put('/category/update/{id}', 'CategoryController@update');
        Route::get('/category/delete/{id}', 'CategoryController@destroy');

        Route::get('/subcategory/create', 'SubcategoryController@create');
        Route::post('/subcategory/store', 'SubcategoryController@store')->name('subcategory-store');
        Route::get('/subcategory/edit/{id}', 'SubcategoryController@edit');
        Route::put('/subcategory/update/{id}', 'SubcategoryController@update');
        Route::get('/subcategory/delete/{id}', 'SubcategoryController@destroy');

        Route::get('/subcategorytype/create/{id}', 'SubcategorytypeController@create');
        Route::post('/subcategorytype/store', 'SubcategorytypeController@store')->name('subcategorytype-store');

        Route::put('/subcategorytype/generateQr', 'SubcategorytypeController@generateQr');
        Route::get('/subcategorytype/edit/{id}', 'SubcategorytypeController@edit');
        Route::put('/subcategorytype/update/{id}', 'SubcategorytypeController@update');
        Route::get('/subcategorytype/delete/{id}', 'SubcategorytypeController@destroy');

        Route::post('/attributemaster/store', 'AttributeMasterController@store')->name('attributemaster-store');
        Route::get('/attributemaster/delete/{id}', 'AttributeMasterController@destroy');
        Route::get('/attributemaster/create', 'AttributeMasterController@create')->name('attributemaster-create');

        Route::get('/attributechange/approve/{id}', 'AttributeChangeController@approve');
        Route::post('/attributechange/store', 'AttributeChangeController@store')->name('attributechange-store');
        Route::get('/attributechange/delete/{id}', 'AttributeChangeController@destroy');
        Route::put('/attributechange/reject/{id}', 'AttributeChangeController@reject');

        Route::get('/unitmaster/create', 'UnitMasterController@create');
        Route::post('/unitmaster/store', 'UnitMasterController@store');
        Route::get('/unitmaster/delete/{id}', 'UnitMasterController@destroy');


    });
    Route::group(['middleware' => ['role:super-admin|admin|approver|editor']], function () {
        Route::get('/jobs', 'JobController@index');
        Route::get('/jobsf/{prop}', 'JobController@indexId');
        Route::get('/job/create', 'JobController@create');
        Route::post('/job/store', 'JobController@store');
        Route::get('/job/delete/{id}', 'JobController@destroy');

        Route::get('/product/create/{id}', 'ProductController@create');
        Route::post('/product/store', 'ProductController@store');
        Route::get('/product/delete/{id}', 'ProductController@destroy');
        Route::put('/product/edit/{id}', 'ProductController@edit');

    });
    Route::group(['middleware' => ['role:super-admin|admin|approver']], function () {
        Route::get('/product/approve/{id}', 'ProductController@approve');
        Route::put('/product/reject/{id}', 'ProductController@reject');
        Route::put('/product/listaction',  'ProductController@listaction');

         //excel imports
        Route::get('/entry', 'TableImportController@index')->name('entry');
        Route::post('import', 'TableImportController@import')->name('import');
    });

    Route::get('/categories', 'CategoryController@index')->name('categories');

    Route::get('/subcategories', 'SubcategoryController@index')->name('subcategories');
    Route::get('/subcategories/{id}', 'SubcategoryController@indexById');
    Route::get('/subcategory/show/{id}', 'SubcategoryController@show');


    Route::get('/subcategorytypes/{id}', 'SubcategorytypeController@index')->name('subcategorytypes');
    Route::get('/subcategorytype/show/{id}', 'SubcategorytypeController@show');


    Route::get('/attributes', 'AttributesController@index')->name('attributes');
    Route::get('/attribute/create', 'AttributesController@create')->name('attribute-create');
    Route::post('/attribute/store', 'AttributesController@store')->name('attribute-store');
    Route::get('/attribute/create/{id}', 'AttributesController@create');
    Route::get('/attribute/delete/{id}', 'AttributesController@destroy');


    Route::get('/attributemasters', 'AttributeMasterController@index')->name('attributemasters');



    Route::put('/job/edit/{id}', 'JobController@edit');
    Route::get('/job/approve/{id}', 'JobController@approve');
    Route::get('/job/disapprove/{id}', 'JobController@disapprove');

    Route::get('/product/getsubcategories/{id}', 'ProductController@getSubcategories');
    Route::get('/product/gettypes/{id}', 'ProductController@getTypes');
    Route::get('/product/getunits', 'ProductController@getUnits');
    Route::get('/product/getattributes/{id}', 'ProductController@getAttributes');
    Route::post('/product/generateqr/{id}', 'ProductController@generateQr');

    Route::get('/unitmasters', 'UnitMasterController@index');

    Route::get('/myprofile/{user}/edit', 'UserController@editprofile');
    Route::put('/myprofile/update/{id}', 'UserController@updateprofile');
    Route::post('/job/search', 'JobController@search');




});



