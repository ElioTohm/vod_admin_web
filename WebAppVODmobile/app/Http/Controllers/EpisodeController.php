<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Serie;
use SherifTube\Episode;
use GuzzleHttp\Client;

class EpisodeController extends Controller
{
    public function index ($imdbID)
    {
    	$serie = Serie::where('imdbID', $imdbID)->get();

    	return view('series.episodes')->with('serie', $serie[0]); 
    }

    public function addEpisode (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$result = $this->imdbAPIRequest($request->get('imdbID'));//$data['imdbID']);

 		$info = json_decode($result, true);

 		if ($info['Response'] == "True" && $this->checkSeriesExists($info['seriesID'])) {
            //convert string to date
 			$date = strtotime($info['Released']);

			$episode = new Episode();

			$episode->imdbID = $info['imdbID'];
			$episode->Title = $info['Title'];
			$episode->Year = $info['Year'];
			$episode->Rated = $info['Rated'];
			$episode->Released = date('Y-m-d', $date);
			$episode->Season = $info['Season'];
			$episode->Episode = $info['Episode'];
			$episode->seriesID = $info['seriesID'];
			$episode->Runtime = $info['Runtime'];
			$episode->Director = $info['Director'];
			$episode->Writer = $info['Writer'];
			$episode->Actors = $info['Actors'];
			$episode->Plot = $info['Plot'];
			$episode->Language = $info['Language'];
			$episode->Country = $info['Country'];
			$episode->Awards = $info['Awards'];
			$episode->Poster = $info['Poster'];
			$episode->Metascore = (int)$info['Metascore'];
			$episode->imdbRating = $info['imdbRating'];
			$episode->imdbVotes = $info['imdbVotes'];
			$episode->Type = $info['Type'];
			$episode->seriesID = $info['seriesID'];
			$episode->stream = $request->get('stream');
          	$episode->save();
           
          
            $relatedseries = Serie::where('imdbID', $info['seriesID'])->first();
            $sections = view('series.episodes')->with('serie', $relatedseries)
                                          ->renderSections();
 
            
            return $sections['episodesdetails'];

 		} else {
 			return json_encode('{error:"No Episodes Found"}');
 		}
    		
    }

    private function checkSeriesExists ($seriesID)
	{
		$serie = Serie::where('imdbID', '=', $seriesID)->first();
            if ($serie === null) {
				return false;                
            } else {
                return true;
            }
	}

	private function deleteEpisode (Request $request)
	{

	}

	private function imdbAPIRequest ($imdbID)
    {
    	$client = new Client();
		$response = $client->get("http://www.omdbapi.com/?i=". $imdbID ."&y=&plot=full&r=json");
		return $response->getBody();
    }
}
