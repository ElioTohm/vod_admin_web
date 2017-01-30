<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Client;
use SherifTube\Movie;
use SherifTube\Serie;
use SherifTube\Episode;
use SherifTube\Genre;

class APIController extends Controller
{
    public function clientSignin (Request $request) 
    {
 		$data = json_decode($request->getContent(),true);
 		
 		// check if client is active
 		$result = Client::where('email', $data['usermail'])
	 					->first(['active']);
		if ($result === null) {
			return response()->json([
					'registered' => 0,
					'active' => 0
				]);
		} else {
			return response()->json([
					'registered' => 1,
					'active' => $result['active']
				]);
		} 

 		// return json_encode('{"test":"1"}');
 		return response()->json([
				    'name' => $data['usermail'],
				    'state' => 'CA'
				]);
 	}

 	public function clientRegister (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		$client = new Client();
 		$client->password = bcrypt($data['password']);
 		$client->email = $data['usermail'];
 		$client->active = 0;
 		$client->save();

 		return response()->json([
					'registered' => 1,
					'active' => 0
				]);
 	}

 	public function getMovies (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		if ($data[0]['genre'] == 9999) {
 			
 			$movies = Movie::get();
 		
 		} else {

			$movies = \DB::table('movies')
		            ->join('movie_genres', 'movie_genres.imdbID', '=', 'movies.imdbID')
		            ->join('genres', 'genres.genre_id', '=', 'movie_genres.genre_id')
		            ->where('genres.genre_id', $data[0]['genre'] )
		            ->get();		 			
 		}

 		return response()->json($movies);
 	}

 	public function getSeries (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);
 		
		if ($data[0]['genre'] == 9999) {
 			
 			$series = Serie::get();
 		
 		} else {

			$series = \DB::table('series')
		            ->join('serie_genres', 'serie_genres.imdbID', '=', 'series.imdbID')
		            ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
		            ->where('genres.genre_id', $data[0]['genre'] )
		            ->get();		 			
 		}

 		return response()->json($series);
 	}

 	public function getEpisodes (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		$episodes = Episode::where('seriesID', $data['imdbID'])
 							->where('season', $data['season'])
 							->get();

 		return response()->json($episodes);
 	}

 	public function getSeasons (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		$episodes = Episode::where('seriesID', $data[0]['imdbID'])
 							->groupBy(['season'])
 							->get(['season']);

 		return response()->json($episodes);
 	}

	public function getGenres (Request $request)
 	{
 		$genres = Genre::get(['genre_id', 'genre_name']);

 		return response()->json($genres);
 	} 	
}
