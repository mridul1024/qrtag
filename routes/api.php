<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Cache;


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


Route::get('/product/show/{id}', 'ProductController@show');
Route::post('/product/material', 'ProductController@showMId');
Route::get('/job/show/{id}', 'JobController@show');

//Caching
Route::get('/product/cache', 'ProductController@cacheFields');
Route::get('/product/clearcache', 'ProductController@clearCache');


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

    Route::get('/subcategorytypes/{id}', 'SubcategorytypeController@index');
    Route::get('/subcategorytype/create/{id}', 'SubcategorytypeController@create');
    Route::post('/subcategorytype/store', 'SubcategorytypeController@store');
    Route::get('/subcategorytype/show/{id}', 'SubcategorytypeController@show');
    Route::get('/subcategorytype/edit/{id}', 'SubcategorytypeController@edit');
    Route::put('/subcategorytype/update/{id}', 'SubcategorytypeController@update');
    Route::get('/subcategorytype/delete/{id}', 'SubcategorytypeController@destroy');

    Route::get('/attributemaster/create', 'AttributeMasterController@create'); // a web specific api, not mandatory for mobile
    Route::get('/attributemasters', 'AttributeMasterController@index');
    Route::post('/attributemaster/store', 'AttributeMasterController@store');
    Route::get('/attributemaster/delete/{id}', 'AttributeMasterController@destroy');

    Route::get('/unitmaster/create', 'UnitMasterController@create'); // a web specific api, not mandatory for mobile
    Route::get('/unitmasters', 'UnitMasterController@index');
    Route::post('/unitmaster/store', 'UnitMasterController@store');
    Route::get('/unitmaster/delete/{id}', 'UnitMasterController@destroy');

    Route::get('/attributes', 'AttributesController@index');
//    Route::get('/attribute/create', 'AttributesController@create');
    Route::post('/attribute/store', 'AttributesController@store');
    Route::get('/attribute/create/{id}', 'AttributesController@create');
    Route::get('/attribute/delete/{id}', 'AttributesController@destroy');



    //job + product + product attributes

    Route::get('/jobs', 'JobController@index');
    Route::get('/jobsf/{prop}', 'JobController@indexId');
    Route::get('/job/create', 'JobController@create');
    Route::post('/job/store', 'JobController@store');
    Route::put('/job/edit/{id}', 'JobController@edit');
    Route::get('/job/approve/{id}', 'JobController@approve');
    Route::get('/job/disapprove/{id}', 'JobController@disapprove');
    Route::get('/job/delete/{id}', 'JobController@destroy');

    //Route::get('/jobs', 'JobController@index');
    Route::get('/product/create/{id}', 'ProductController@create');
    Route::post('/product/store', 'ProductController@store');
    Route::get('/product/delete/{id}', 'ProductController@destroy');
    Route::put('/product/edit/{id}', 'ProductController@edit');
    Route::get('/product/getsubcategories/{id}', 'ProductController@getSubcategories');
    Route::get('/product/gettypes/{id}', 'ProductController@getTypes');
    Route::get('/product/getunits', 'ProductController@getUnits');
    Route::get('/product/getattributes/{id}', 'ProductController@getAttributes');
    Route::put('/product/generateQr', 'ProductController@generateQr');
    Route::get('/product/approve/{id}', 'ProductController@approve');
    Route::put('/product/reject/{id}', 'ProductController@reject');
    Route::put('/product/listaction',  'ProductController@listaction');
    Route::get('/product/edit/{id}', 'ProductController@edit');
    Route::put('/product/update', 'ProductController@update');


    Route::get('/attributechange/approve/{id}', 'AttributeChangeController@approve');
    Route::post('/attributechange/store', 'AttributeChangeController@store');
    Route::get('/attributechange/delete/{id}', 'AttributeChangeController@destroy');
    Route::put('/attributechange/reject/{id}', 'AttributeChangeController@reject');


    Route::get('/myprofile/{user}/edit', 'UserController@editprofile');
    Route::put('/myprofile/update/{id}', 'UserController@updateprofile');
    Route::post('/job/search', 'JobController@search');
});



