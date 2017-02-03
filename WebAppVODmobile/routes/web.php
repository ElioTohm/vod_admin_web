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

Route::post('getmovies', 'APIController@getMovies');

Route::post('getseries', 'APIController@getSeries');

Route::post('getepisodes', 'APIController@getEpisodes');

Route::post('getseasons', 'APIController@getSeasons');

Route::post('getgenres', 'APIController@getGenres');

Auth::routes();

/*
 * All routes that needs to be logged in are in this scope
 */

Route::group(['middleware' => ['auth']], function()
{
	Route::get('home', 'HomeController@index');

	//Movies Routes
	Route::get('/movies', 'MovieController@index');
	Route::post('/movies', 'MovieController@addMovie');
	Route::post('/custommovies', 'MovieController@addCustomMovie');
	Route::delete('/movies', 'MovieController@RemoveMovie');
	Route::get('/moviedetails/{imdbID}', 'DetailMovieController@index');
	Route::post('/updatemovies', 'DetailMovieController@UpdateMovie');

	//Series Routes
	Route::get('/series', 'SerieController@index');
	Route::post('/series', 'SerieController@addSerie');
	Route::delete('/series', 'SerieController@RemoveSerie');
	Route::post('/customseries', 'SerieController@AddCustomSeries');

	//Episodes Routes
	Route::get('/seriesDetail/{imdbID}', 'EpisodeController@index');
	Route::post('/episodes', 'EpisodeController@addEpisode');
	Route::delete('/episodes', 'EpisodeController@deleteEpisode');

	//Clients Routes
	Route::get('/clients', 'ClientsController@clientindex');
	Route::get('/activeclients', 'ClientsController@activeclientindex');
	Route::post('/activeclients', 'ClientsController@activate');	
	Route::post('/deactiveclients', 'ClientsController@deactivate');
	Route::delete('/clients', 'ClientsController@delete');	

});

