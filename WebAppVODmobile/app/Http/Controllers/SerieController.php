<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Serie;
use SherifTube\Genre;
use SherifTube\SerieGenre;
use GuzzleHttp\Client;
use GuzzleHttp\Episode;
use Intervention\Image\Facades\Image;

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

        if ($data['custom'] == false) {
            return $this->imdbSerie($data);
        } else {
            return $this->AddCustomSeries($data);
        }
    }

	private function imdbSerie ($data)
	{
    	$result = $this->imdbAPIRequest($data['imdbID']);//$request->get('imdbID'));

 		$info = json_decode($result, true);

 		if ($info['Response'] == "True") {
            //convert string to date
 			$date = strtotime($info['Released']);
            $image = Image::make($info['Poster'])->encode('png', 50)->save(public_path('videoimages/'. $info['imdbID'] .'.png'));

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
            $serie->Poster = \Config::get('app.base_url').'videoimages/'. $info['imdbID'] .'.png';
            $serie->Metascore = (int)$info['Metascore'];
            $serie->imdbRating = $info['imdbRating'];
            $serie->imdbVotes = $info['imdbVotes'];
            $serie->Type = $info['Type'];
            $serie->totalSeasons = $info['totalSeasons'];
            $serie->storage = $info['storage'];
            $serie->save();

            //add foreign keys
            $this->checkGenreExists($info['Genre'], $serie->id);
            
           // return redirect()->action('SerieController@index');
            $series = Serie::orderBy('Title', 'asc')->paginate(12);
            $sections =  view('series.series')->with('series', $series)->renderSections();
             
            return $sections['series_list'];
 		} else {
 			return json_encode('{error:"No serie Found"}');
 		}

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

        $this->AddSerieGenreRelation ($genrenumber,$imdbID);
        
    }

    private function addGenre ($genrename)
    {
        //create Genre
        $genre = new Genre();
        $genre->genre_name = $genrename;
        $genre->save();

        $genreid = Genre::where('genre_name', $genrename)->pluck('genre_id');
        //return id to be added in array
        return $genreid[0];
    }

    /**
     * AddSerieGenreRelation takes array of genres numbers and add them with the 
     * corresponding serie imdb to this is done to fill the many-to-many table
     **/
    private function AddSerieGenreRelation ($genrearray,$imdbID)
    {
        foreach ($genrearray as $key => $value) {
            $seriegenre = new SerieGenre();
            $seriegenre->id = $imdbID;
            $seriegenre->genre_id = $value;
            $seriegenre->save();   
        }

    }

	public function RemoveSerie (Request $request)
	{
		$data = json_decode($request->getContent(),true);
        
        $serie = Serie::find($data['imdbID']);

        //uses Model function to delete
        $serie->delete();

        return $data['imdbID'];
	}

	private function AddCustomSeries ($data)
    {
        $imdbID = hash('md5', $data['Title']);

        if (filter_var($data['Poster'], FILTER_VALIDATE_URL) && getimagesize($data['Poster'])) {
            $Downloadedimage = Image::make($data['Poster'])->encode('png', 50)->save(public_path('videoimages/'. $imdbID .'.png'));
            $image = \Config::get('app.base_url').'videoimages/'. $imdbID .'.png';
        } else if(!empty($data['PosterUpload'])) {
             $data['PosterUpload']->move(public_path('videoimages/'), $input['imagename']);
             $image = \Config::get('app.base_url').'videoimages/'. $imdbID .'.png';
        } else {
            $image = "N/A";
        }

        $serie = new Serie();
        $serie->imdbID = hash('md5', $data['Title']);
        $serie->Title = $data['Title'];
        $serie->Year = $data['Year'];
        $serie->Rated = $data['Rated'];
        $serie->Released = $data['Released'];
        $serie->Runtime = $data['Runtime'];
        $serie->Director = $data['Director'];
        $serie->Writer = $data['Writer'];
        $serie->Actors = $data['Actors'];
        $serie->Plot = $data['Plot'];
        $serie->Language = $data['Language'];
        $serie->Country = $data['Country'];
        $serie->Awards = $data['Awards'];
        $serie->Poster = \Config::get('app.base_url').'videoimages/'. $imdbID .'.png';
        $serie->Metascore = 0;
        $serie->imdbRating = 0.0;
        $serie->imdbVotes = 'N/A';
        $serie->Type = 'series';
        $serie->totalSeasons = 'N/A';
        $serie->storage = $data['storage'];
        $serie->save();

        // return redirect()->action('SerieController@index');
        $series = Serie::orderBy('Title', 'asc')->paginate(12);
        $sections =  view('series.series')->with('series', $series)->renderSections();
         
        return $sections['series_list'];
    }

}
