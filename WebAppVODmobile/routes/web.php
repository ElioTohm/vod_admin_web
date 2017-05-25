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

Route::post('clientsingin', 'APIController@clientSignin');

Route::post('clientregister', 'APIController@clientRegister');

Route::post('getmovies', 'APIController@getMovies');

Route::post('getclips', 'APIController@getClips');

Route::post('getseries', 'APIController@getSeries');

Route::post('getepisodes', 'APIController@getEpisodes');

Route::post('getseasons', 'APIController@getSeasons');

Route::post('getgenres', 'APIController@getGenres');

Route::post('getartists', 'APIController@getArtists');

Auth::routes();

/*
 * All routes that needs to be logged in are in this scope
 */

Route::group(['middleware' => ['auth']], function()
{
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	
	//Movies Routes
	Route::get('/movies', 'MovieController@index');
	Route::post('/movies', 'MovieController@addMovie');
	Route::delete('/movies', 'MovieController@RemoveMovie');
	Route::get('/moviedetails/{imdbID}', 'DetailMovieController@index');
	Route::post('/updatemovies', 'DetailMovieController@UpdateMovie');
	Route::post('/uploadMoviePoster', 'DetailMovieController@UploadPosterMovie');

	//Series Routes
	Route::get('/series', 'SerieController@index');
	Route::post('/series', 'SerieController@addSerie');
	Route::delete('/series', 'SerieController@RemoveSerie');

	//Episodes Routes
	Route::get('/seriesDetail/{imdbID}', 'EpisodeController@index');
	Route::post('/episodes', 'EpisodeController@addEpisode');
	Route::delete('/episodes', 'EpisodeController@deleteEpisode');
	Route::post('/customepisodes', 'EpisodeController@AddCustomEpisode');
	Route::post('/updateepisodes', 'EpisodeController@UpdateEpisode');
	Route::post('/updateseries', 'EpisodeController@UpdateSerie');
	Route::post('/uploadSeriePoster', 'EpisodeController@UploadSeriePoster');

	//Clients Routes
	Route::get('/clients', 'ClientsController@clientindex');
	Route::get('/activeclients', 'ClientsController@activeclientindex');
	Route::post('/activeclients', 'ClientsController@activate');	
	Route::post('/deactiveclients', 'ClientsController@deactivate');
	Route::delete('/clients', 'ClientsController@delete');	

	//Genres Routes
	Route::get('genres', 'GenreController@Index');
	Route::post('genres', 'GenreController@AddGenres');
	Route::delete('genres', 'GenreController@DeleteGenres');

	//Clips Routes
	Route::get('/clips/{artist_id}', 'ClipController@index');
	Route::post('/clips', 'ClipController@addClip');
	Route::delete('/clips', 'ClipController@RemoveClip');
	Route::post('/clipsudpate','ClipController@UpdateClip');
	Route::post('/clip','ClipController@getClipInfo');
	Route::post('multiclips', 'ClipController@MultiClip');

	//artist
	Route::get('/artists', 'ArtistController@index');
	Route::post('/artistsupate', 'ArtistController@UpdateArtist');
	Route::post('/artists', 'ArtistController@AddArtist');
	Route::delete('/artists', 'ArtistController@DeleteArtist');
});

