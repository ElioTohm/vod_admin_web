<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Movie;
use Intervention\Image\Facades\Image;

class DetailMovieController extends Controller
{
    public function index ($imdbID)
    {
    	$movie = Movie::where('id', $imdbID)->first();
        $genres = \DB::table('movie_genres')->where('id', $movie->id)
                        ->join('genres', 'genres.genre_id', '=', 'movie_genres.genre_id')
                        ->groupBy('movie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);

    	return view('movie.movie_details')->with('movie', $movie)
                                            ->with('genres', $genres)
                                            ->with('allgenres', $allgenres);
    }

    public function UpdateMovie (Request $request)
    {
    	$data = json_decode($request->getContent(),true);
 
        if (filter_var($data['Poster'], FILTER_VALIDATE_URL) && getimagesize($data['Poster'])) {
            $Downloadedimage = Image::make($data['Poster'])->encode('jpg', 80)->save(public_path('VideoImages/'. $data['originalID'] .'.png'));
            $image = \Config::get('app.base_url').'VideoImages/'. $data['originalID'] .'.png';
        } else {
            $image = "N/A";
        }

    	Movie::where('imdbID', $data['originalID'])
    			->update([
    					'Title' => $data['Title'],
				        'Year' => $data['Year'],
				        'Rated' => $data['Rated'],
				        'Released' => $data['Released'],
				        'Runtime' => $data['Runtime'], 
				        'Director' => $data['Director'], 
				        'Writer' => $data['Writer'],
				        'Actors' => $data['Actors'], 
				        'Plot' => $data['Plot'],
				        'Language' => $data['Language'],
				        'Country' => $data['Country'],
				        'Awards' => $data['Awards'],
				        'Poster' => $image,
				        'stream' => $data['Stream'],
                        'imdbID' => hash('md5', $data['Title']),
    				]);

    	$movie = Movie::where('imdbID', hash('md5', $data['Title']))->first();
        $genres = \DB::table('movie_genres')->where('id', $movie->id)
                        ->join('genres', 'genres.genre_id', '=', 'movie_genres.genre_id')
                        ->groupBy('movie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
        $sections = view('movie.movie_details')->with('movie', $movie)->with('genres', $genres)
                                    ->with('allgenres', $allgenres)->renderSections();
        return $sections['movie_detail'];   
    }
}
