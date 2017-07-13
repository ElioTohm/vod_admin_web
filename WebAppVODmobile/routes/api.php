<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['auth:api']], function()
{
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});

	Route::get('/stream/{type}/{videoid}','APIController@serve');

	

	Route::post('getmovies', 'APIController@getMovies');

	Route::post('getclips', 'APIController@getClips');

	Route::post('getseries', 'APIController@getSeries');

	Route::post('getepisodes', 'APIController@getEpisodes');

	Route::post('getseasons', 'APIController@getSeasons');

	Route::post('getgenres', 'APIController@getGenres');

	Route::post('getartists', 'APIController@getArtists');

});

Route::post('clientregister', 'APIController@clientRegister');

Route::post('clientsingin', 'APIController@clientSignin');