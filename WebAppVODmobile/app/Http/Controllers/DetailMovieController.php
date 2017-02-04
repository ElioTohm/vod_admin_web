<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Movie;

class DetailMovieController extends Controller
{
    public function index ($imdbID)
    {
    	$movie = Movie::where('imdbID', $imdbID)->first();
    	return view('movie.movie_details')->with('movie', $movie);
    }

    public function UpdateMovie (Request $request)
    {
    	$data = json_decode($request->getContent(),true);
    	

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
				        'Poster' => $data['Poster'],
				        'stream' => $data['Stream'],
    				]);

    	$movie = Movie::where('imdbID', $data['imdbID'])->first();
                $sections = view('movie.movie_details')->with('movie', $movie)
                                              ->renderSections();
        return $sections['movie_detail'];   
    }
}
