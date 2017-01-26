<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('clientsingin', 'APIController@clientSignin');

Route::post('clientregister', 'APIController@clientRegister');

Auth::routes();

/*
 * All routes that needs to be logged in are in this scope
 */

Route::group(['middleware' => ['auth']], function()
{

	Route::get('/home', 'HomeController@index');

	Route::get('/movies', 'MovieController@index');

	Route::post('/movies', 'MovieController@addMovie');

	Route::delete('/movies', 'MovieController@RemoveMovie');

	Route::get('categories', 'CategoryController@index');
	
	Route::post('categories', 'CategoryController@addCategory');

	Route::get('clients', 'ClientsController@index');

	Route::post('clients', 'ClientsController@activate');

	Route::delete('clients', 'ClientsController@delete');

});

