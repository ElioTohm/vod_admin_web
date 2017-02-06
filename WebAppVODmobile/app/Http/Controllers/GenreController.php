<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Genre;

class GenreController extends Controller
{
    public function Index ()
    {
    	$genres = Genre::get();
    	return view ('genre.genre')->with('genres', $genres);
    }

    public function AddGenres (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$genre = new Genre();
    	$genre->genre_name = $data['genre_name'];
    	$genre->save();

    	$genres = Genre::get();
    	$sections = view ('genre.genre')->with('genres', $genres)->renderSections();

    	return $sections['genres'];
    }

    public function DeleteGenres (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

		Genre::where('genre_id', $data['genre_id'])
        ->delete();
    }
}
