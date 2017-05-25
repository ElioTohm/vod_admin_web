<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Http\Requests;
use SherifTube\Movie;
use SherifTube\Genre;
use SherifTube\MovieGenre;
use GuzzleHttp\Client;
use Intervention\Image\Facades\Image;

class MovieController extends Controller
{
    public function index () 
    {
    	$Movies = Movie::orderBy('Title', 'asc')->paginate(12);
    	return view('movies')->with('movies', $Movies);
    }
    
    public function addMovie (Request $request) 
    {
        $data = json_decode($request->getContent(),true);

        if ($data['custom'] == false) {
            return $this->imdbMovie($data);
        } else {
            return $this->addCustomMovie($data);
        }
    } 

    private function imdbMovie ($data)
    {
        
        
    	$result = $this->imdbAPIRequest($data['imdbID']);//$request->get('imdbID'));//

 		$info = json_decode($result, true);

 		if ($info['Response'] == "True") {
            if($info['Type'] == 'movie') {
                //convert string to date
                $date = strtotime($info['Released']);
                $image = Image::make($info['Poster'])->encode('png', 80)->save(public_path('videoimages/'. $info['imdbID'] .'.png'));
                $movie = new Movie();
                $movie->Title = $info['Title'];
                $movie->Year = $info['Year'];
                $movie->Rated = $info['Rated'];
                $movie->Released = date('Y-m-d',$date);
                $movie->Runtime = $info['Runtime'];
                $movie->Director = $info['Director'];
                $movie->Writer = $info['Writer'];
                $movie->Actors = $info['Actors'];
                $movie->Plot = $info['Plot'];
                $movie->Language = $info['Language'];
                $movie->Country = $info['Country'];
                $movie->Awards = $info['Awards'];
                $movie->Poster = \Config::get('app.base_url').'videoimages/'. $info['imdbID'] .'.png';
                $movie->Metascore = (int)$info['Metascore'];
                $movie->imdbRating = (float)$info['imdbRating'];
                $movie->imdbVotes = $info['imdbVotes'];
                $movie->imdbID = $info['imdbID'];
                $movie->Type = $info['Type'];
                $movie->stream = $data['stream'];//$request->get('stream');//
                $movie->Subtitle = $data['Subtitle'];
                $movie->save();
                
                //add foreign keys
                $this->checkGenreExists($info['Genre'], $movie->id);
                
                // return redirect()->action('MovieController@index'); 
                $Movies = Movie::orderBy('Title', 'asc')->paginate(12);  
                $sections =  view('movies')->with('movies', $Movies)->renderSections(); 
               
                return $sections['movie_list'];
            } else {
                return json_encode('{error:"Not a movie", "errorcode":401}');    
            }
            
            // return json_encode($info['Response']);
 		} else {
 			return json_encode('{error:"No movie Found", "errorcode":402}');
 		}

    	// return $info['Response'];

    }

    private function imdbAPIRequest ($imdbID)
    {
    	$client = new Client();
		$response = $client->get("http://www.omdbapi.com/?i=". $imdbID ."&plot=short&r=json");
		return $response->getBody();
    }

    private function checkGenreExists ($genre, $imdbID) {
        //explode string
        $pos = strpos($genre, ',');
        $genrearray = array();
        $genrenumber = array();
        
        //check if its 1 genre of multiple
        if ($pos !== false) {
            $genrearray = array_map('trim', explode(',', $genre));
        } else {
            array_push($genrearray, $genre);
        }
       
        //foreach genre in array check if genre exists
        foreach ($genrearray as $key => $value) {
            $genre = Genre::where('genre_name', '=', $value)->first();
            if ($genre === null) {
                
                //if genre does not exist add and return genre_id
                array_push($genrenumber, $this->addGenre($value));
            } else {
                
                //if exist add genre id to array
                $genre_id =  Genre::where('genre_name', '=', $value)->pluck('genre_id');
                array_push($genrenumber, $genre_id[0]);
            }
        }

        $this->AddMovieGenreRelation ($genrenumber,$imdbID);
        
    }

    private function addGenre ($genrename)
    {
        //create Genre
        $genre = new Genre();
        $genre->genre_name = $genrename;
        $genre->save();

        $genre_id = Genre::where('genre_name', $genrename)->pluck('genre_id');

        //return id to be added in array
        return $genre_id[0];
    }

    /**
     * AddMovieGenreRelation takes array of genres numbers and add them with the 
     * corresponding movie imdb to this is done to fill the many-to-many table
     **/
    private function AddMovieGenreRelation ($genrearray,$imdbID)
    {
        foreach ($genrearray as $key => $value) {
            $moviegenre = new MovieGenre();
            $moviegenre->id = $imdbID;
            $moviegenre->genre_id = $value;
            $moviegenre->save();   
        }

    }

    public function RemoveMovie (Request $request)
    {
        $data = json_decode($request->getContent(),true);
        
        $movie = Movie::find($data['imdbID']);

        //uses Model function to delete
        $movie->delete();

        return $data['imdbID'];
    }

    private function addCustomMovie ($data)
    {
        $imdbID = hash('md5', $data['Title']);

        if (filter_var($data['Poster'], FILTER_VALIDATE_URL) && getimagesize($data['Poster'])) {
            $Downloadedimage = Image::make($data['Poster'])->encode('png', 80)->save(public_path('videoimages/'. $imdbID .'.png'));
            $image = \Config::get('app.base_url').'videoimages/'. $imdbID .'.png';
        } else if(!empty($data['PosterUpload'])) {
             $data['PosterUpload']->move(public_path('videoimages/'), $input['imagename']);
             $image = \Config::get('app.base_url').'videoimages/'. $imdbID .'.png';
        } else {
            $image = "N/A";
        }

        $movie = new Movie();
        $movie->Title = $data['Title'];
        $movie->Year = $data['Year'];
        $movie->Rated = $data['Rated'];
        $movie->Released = $data['Released'];
        $movie->Runtime = $data['Runtime']; 
        $movie->Director = $data['Director']; 
        $movie->Writer = $data['Writer'];
        $movie->Actors =$data['Actors']; 
        $movie->Plot = $data['Plot'];
        $movie->Language = $data['Language'];
        $movie->Country = $data['Country'];
        $movie->Awards = $data['Awards'];
        $movie->Poster = $image;
        $movie->Metascore = 0;
        $movie->imdbRating = 0.0;
        $movie->imdbVotes = 'N/A';
        $movie->imdbID = $imdbID;
        $movie->Type = 'movie';
        $movie->stream = $data['Stream'];
        $movie->Subtitle = $data['Subtitle'];
        $movie->save();

        // return redirect()->action('MovieController@index');
        $Movies = Movie::orderBy('Title', 'asc')->paginate(12);  
        $sections =  view('movies')->with('movies', $Movies)->renderSections(); 
       
        return $sections['movie_list'];
    }

    
}
