<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Serie;
use SherifTube\Genre;
use SherifTube\SerieGenre;
use GuzzleHttp\Client;
use GuzzleHttp\Episode;

class SerieController extends Controller
{
    public function index ()
    {
    	$series = Serie::orderBy('Title', 'asc')->paginate(12);
    	return view('series.series')->with('series', $series);
    }

	public function addSerie (Request $request)
	{
    	$data = json_decode($request->getContent(),true);

    	$result = $this->imdbAPIRequest($data['imdbID']);//$request->get('imdbID'));

 		$info = json_decode($result, true);

 		if ($info['Response'] == "True") {
            //convert string to date
 			$date = strtotime($info['Released']);

 			$serie = new Serie();
			$serie->imdbID = $info['imdbID'];
            $serie->Title = $info['Title'];
            $serie->Year = $info['Year'];
            $serie->Rated = $info['Rated'];
            $serie->Released = date('Y-m-d',$date);
            $serie->Runtime = $info['Runtime'];
            $serie->Director = $info['Director'];
            $serie->Writer = $info['Writer'];
            $serie->Actors = $info['Actors'];
            $serie->Plot = $info['Plot'];
            $serie->Language = $info['Language'];
            $serie->Country = $info['Country'];
            $serie->Awards = $info['Awards'];
            $serie->Poster = $info['Poster'];
            $serie->Metascore = (int)$info['Metascore'];
            $serie->imdbRating = $info['imdbRating'];
            $serie->imdbVotes = $info['imdbVotes'];
            $serie->Type = $info['Type'];
            $serie->totalSeasons = $info['totalSeasons'];
            $serie->save();

            //add foreign keys
            $this->checkGenreExists($info['Genre'], $info['imdbID']);
            
            $allseries = Serie::orderBy('Title', 'asc')->paginate(12);
            $sections = view('series.series')->with('series', $allseries)
                                          ->renderSections();
 
            return $sections['series_list'];
 		} else {
 			return json_encode('{error:"No serie Found"}');
 		}

    }

    private function imdbAPIRequest ($imdbID)
    {
    	$client = new Client();
		$response = $client->get("http://www.omdbapi.com/?i=". $imdbID ."&y=&plot=full&r=json");
		return $response->getBody();
    }

    private function checkGenreExists ($genre, $imdbID) {
        //explode string
        $pos = strpos($genre, ',');
        $genrearray = array();
        $genrenumber = array();
        
        //check if its 1 genre of multiple
        if ($pos !== false) {
            $genrearray = explode(',', $genre); 
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

        $this->AddSerieGenreRelation ($genrenumber,$imdbID);
        
    }

    private function addGenre ($genrename)
    {
        //create Genre
        $genre = new Genre();
        $genre->genre_name = $genrename;
        $genre->save();

        //get genre_id that was entered
        $genre_id =  Genre::where('genre_name', '=', $genrename)->pluck('genre_id');

        //return id to be added in array
        return $genre_id[0];
    }

    /**
     * AddSerieGenreRelation takes array of genres numbers and add them with the 
     * corresponding serie imdb to this is done to fill the many-to-many table
     **/
    private function AddSerieGenreRelation ($genrearray,$imdbID)
    {
        foreach ($genrearray as $key => $value) {
            $seriegenre = new SerieGenre();
            $seriegenre->imdbID = $imdbID;
            $seriegenre->genre_id = $value;
            $seriegenre->save();   
        }

    }

	public function RemoveSerie (Request $request)
	{
		$data = json_decode($request->getContent(),true);
        
        $serie = new Serie();

        //uses Model function to delete
        $serie->DeleteSeries($data['imdbID']);

        return $data['imdbID'];
	}

	

}
