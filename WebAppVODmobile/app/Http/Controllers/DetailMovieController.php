<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Http\Requests;
use SherifTube\Movie;
use Intervention\Image\Facades\Image;
use SherifTube\Genre;
use SherifTube\MovieGenre;

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
            $Downloadedimage = Image::make($data['Poster'])->encode('png', 80)->save(public_path('videoimages/'. $data['originalID'] .'.png'));
            $image = \Config::get('app.base_url').'videoimages/'. $data['originalID'] .'.png';
        } else {
            $image = "N/A";
        }

        $this->checkGenreExists($data['Genre'], $data['id']);

        if(!empty($data['Stream'])) {
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
        } else {
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
                        'imdbID' => hash('md5', $data['Title']),
                    ]);
        }

    	

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

    public function UploadPosterMovie (Request $request)
    {
        $id = $request->get('movieid');

        if ($request->hasFile('PosterUpload')) {
            $this->validate($request, [
                'PosterUpload' => 'image|mimes:jpeg,png,png',
            ]);
            $poster = $request->file('PosterUpload');
            $poster->move(public_path('videoimages/'), $poster->getClientOriginalName());

            Movie::where('id', $id)
                ->update([
                        'Poster' => \Config::get('app.base_url').'videoimages/'. $poster->getClientOriginalName(),
                    ]);
        } else {
            return "no file was uploaded";
        }
        $movie = Movie::where('id', $id)->first();
        return redirect()->back();

    }

    private function checkGenreExists ($genre, $imdbID) {
        $genrenumber = array();
       
        //foreach genre in array check if genre exists
        foreach ($genre as $key => $value) {
            //if exist add genre id to array
            $genre_id =  Genre::where('genre_name', '=', $value)->pluck('genre_id');
            array_push($genrenumber, $genre_id[0]);
        }
        $this->AddMovieGenreRelation ($genrenumber,$imdbID);
    }


    /**
     * AddMovieGenreRelation takes array of genres numbers and add them with the 
     * corresponding movie imdb to this is done to fill the many-to-many table
     **/
    private function AddMovieGenreRelation ($genrearray,$imdbID)
    {
        MovieGenre::where('id', $imdbID)->delete();
        foreach ($genrearray as $key => $value) {
            $moviegenre = new MovieGenre();
            $moviegenre->id = $imdbID;
            $moviegenre->genre_id = $value;
            $moviegenre->save();   
        }

    }
}
