<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Client;
use SherifTube\Movie;
use SherifTube\Serie;
use SherifTube\Episode;
use SherifTube\Genre;
use SherifTube\Clip;
use SherifTube\Artist;

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
					'active' => 0,
					'appversion' => env("APP_VERSION")
				]);
		} else {
			return response()->json([
					'registered' => 1,
					'active' => $result['active'],
					'appversion' => env("APP_VERSION")
				]);
		} 

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
		$movies = NULL;
		
 		if ($data[0]['genre'] == 9999) {
 			
 			$movies = Movie::orderBy('created_at', 'desc')->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster', 'Subtitle', 'stream']);
 		
 		} else {

			$movies = \DB::table('movies')
		            ->join('movie_genres', 'movie_genres.id', '=', 'movies.id')
		            ->join('genres', 'genres.genre_id', '=', 'movie_genres.genre_id')
		            ->where('genres.genre_id', $data[0]['genre'] )
					->orderBy('movies.created_at', 'desc')
		            ->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster', 'Subtitle', 'stream']);		 			
		}
		$result = [];
		foreach ($movies as $key => $movie) {
			array_push($result, [
				'id' => $movie->id,
				'Title' => $movie->Title,
				'Rated' => $movie->Rated,
				'Released' => $movie->Released,
				'Runtime' => $movie->Runtime,
				'Actors' => $movie->Actors,
				'Plot' => $movie->Plot,
				'Poster' => $movie->Poster,
				'Subtitle' => $movie->Subtitle,
				'stream' => $movie->storage . '/' . $movie->stream 
			]);
		}
 		return response()->json($result);
 	}

 	public function getClips (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);
		$clips = NULL; 

 		if ($data[0]['artist_id'] == 1) {
 			
 			$clips = Clip::orderBy('created_at', 'desc')->get();
 		
 		} else {

			$clips = Clip::where('artist_id', $data[0]['artist_id'])
						 ->orderBy('created_at', 'desc')
						 ->get();		 			
 		}

 		return response()->json($clips);
 	}

 	public function getSeries (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);
 		
		if ($data[0]['genre'] == 9999) {
 			
 			$series = Serie::orderBy('series.created_at', 'desc')->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster']);
 		
 		} else {

			$series = \DB::table('series')
		            ->join('serie_genres', 'serie_genres.id', '=', 'series.id')
		            ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
		            ->where('genres.genre_id', $data[0]['genre'] )
					->orderBy('series.created_at', 'desc')
		            ->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster']);		 			
 		}

 		return response()->json($series);
 	}

 	public function getEpisodes (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

		$serie = Serie::where('id', $data[0]['serieID'])->first();
 		$episodes = Episode::where('seriesID', $data[0]['serieID'])
 							->where('season', $data[0]['season'])
							->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Poster', 'Subtitle', 'stream']);
 		$result = [];
		foreach ($episodes as $key => $episode) {
			array_push($result, [
				'Title' => $episode->Title,
				'id' => $episode->episode,
				'Poster' => $episode->Poster,
				'Released' => $episode->Released,
				'Runtime' => $episode->Runtime,
				'Rated' => $episode->Rated,
				'Subtitle' => $episode->Subtitle,
				'stream' =>  $serie->storage . '/' . $episode->stream,				
			]);
		}

 		return response()->json($result);
 	}

 	public function getSeasons (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		$episodes = Episode::where('seriesID', $data[0]['id'])
 							->groupBy(['season'])
 							->get(['season']);

 		return response()->json($episodes);
 	}

	public function getGenres (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);
		$genres = NULL;
 		if ($data[0]['Type'] == "Movies") {
 			$genres = \DB::table('movie_genres')
			            ->join('genres', 'genres.genre_id', '=', 'movie_genres.genre_id')
			            ->groupBy('movie_genres.genre_id')
			            ->get(['genres.genre_name', 'genres.genre_id']);

 		} else if ($data[0]['Type'] == "Series") {
			$genres = \DB::table('serie_genres')
			            ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
			            ->groupBy('serie_genres.genre_id')
			            ->get(['genres.genre_name', 'genres.genre_id']);
 		} else if ($data[0]['Type'] == "Clips") {
 			$genres = \DB::table('clip_genres')
			            ->join('genres', 'genres.genre_id', '=', 'clip_genres.genre_id')
			            ->groupBy('clip_genres.genre_id')
			            ->get(['genres.genre_name', 'genres.genre_id']);
 		}

        return response()->json($genres);
 	} 	

	public function getArtists (Request $request)
	{
		$artists = Artist::orderBy('name')->get(["id", "name", "image"]);

		$result = [];
		foreach ($artists as $key => $artist) {
			array_push($result, [
				'id' => $artist->id,
				'name' => $artist->name,
				'image' => \Config::get('app.base_url') . 'videos/clips_posters/' . $artist->image,
			]);
		}
		return $result;
	}

	public function getNewItems (Request $request) 
	{
		$movies = Movie::orderBy('created_at', 'desc')->take(5)->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster', 'Subtitle', 'stream']);
		$result = [];
		foreach ($movies as $key => $movie) {
			array_push($result, [
				'id' => $movie->id,
				'Title' => $movie->Title,
				'Rated' => $movie->Rated,
				'Released' => $movie->Released,
				'Runtime' => $movie->Runtime,
				'Actors' => $movie->Actors,
				'Plot' => $movie->Plot,
				'Poster' => $movie->Poster,
				'Subtitle' => $movie->Subtitle,
				'stream' => $movie->storage . '/' . $movie->stream 
			]);
		}

		$series = Serie::orderBy('created_at', 'desc')->take(5)->get(['id', 'Title', 'Rated', 'Released', 'Runtime', 'Actors', 'Plot', 'Poster']);

		$artists = Artist::orderBy('created_at', 'desc')->take(5)->get(["id", "name", "image"]);

		return response()->json([
			[
				'title' => 'New Movies',
				'type' => 'Movies',
				'movies_result' => $result
			],
			[
				'title' => 'New Series',
				'type' => 'Series',
				'series_result'=> $series,
			],
			[
				'title' => 'New Artists',
				'type' => 'Artists',
				'artists_result' => $artists
			]
		]);
	}
}
