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
    	$episodes = array();
    	$serie = Serie::where('imdbID', $imdbID)->first();
		$seasons = Episode::where('seriesID', $imdbID)->groupBy('season')->get(['season']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $imdbID)
														->where('season', $seasons[$key]->season)
														->get();
		}
		
    	return view('series.episodes')->with('serie', $serie)
    									->with('seasons', $seasons)
    									->with('episodes', $episodes); 
    }

    public function addEpisode (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$result = $this->imdbAPIRequest($data['imdbID']);//$request->get('imdbID'));//

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
			$episode->stream = $data['stream'];//$request->get('stream');//
          	$episode->save();
           

			$episodes = array();
			$serie = Serie::where('imdbID', $info['seriesID'])->first();
			$seasons = Episode::where('seriesID', $info['seriesID'])->groupBy('season')->get(['season']);
			foreach ($seasons as $key => $value) {
				$episodes[$seasons[$key]->season] = Episode::where('seriesID', $info['seriesID'])
														->where('season', $seasons[$key]->season)
														->get();
			}

			$sections = view('series.episodes')->with('serie', $serie)
										->with('seasons', $seasons)
										->with('episodes', $episodes)
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

	private function imdbAPIRequest ($imdbID)
    {
    	$client = new Client();
		$response = $client->get("http://www.omdbapi.com/?i=". $imdbID ."&plot=short&r=json");
		return $response->getBody();
    }

	public function deleteEpisode (Request $request)
	{
		$data = json_decode($request->getContent(),true);
			
		$episode = new Episode();

        //uses Model function to delete
        $episode->deleteEpisode($data['imdbID']);

        return $data['imdbID'];
	}

	public function AddCustomEpisode(Request $request)
	{
		$data = json_decode($request->getContent(),true);

		$episode = new Episode();
		$episode->imdbID = $data['imdbID'];
		$episode->Title = $data['Title'];
		$episode->Year = $data['Year'];
		$episode->Rated = $data['Rated'];
		$episode->Released = $data['Released'];
		$episode->Season = $data['Season'];
		$episode->Episode = $data['Episode'];
		$episode->Runtime = $data['Runtime'];
		$episode->Director = $data['Director'];
		$episode->Writer = $data['Writer'];
		$episode->Actors = $data['Actors'];
		$episode->Plot = $data['Plot'];
		$episode->Language = $data['Language'];
		$episode->Country = $data['Country'];
		$episode->Awards = $data['Awards'];
		$episode->Poster = $data['Poster'];
		$episode->Metascore = 0;
        $episode->imdbRating = 0.0;
        $episode->imdbVotes = 'N/A';
		$episode->Type = 'episode';
		$episode->seriesID = $data['seriesID'];
		$episode->stream = $data['Stream'];
      	$episode->save();
       

		$episodes = array();
		$serie = Serie::where('imdbID', $data['seriesID'])->first();
		$seasons = Episode::where('seriesID', $data['seriesID'])->groupBy('season')->get(['season']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $data['seriesID'])
													->where('season', $seasons[$key]->season)
													->get();
		}

		$sections = view('series.episodes')->with('serie', $serie)
									->with('seasons', $seasons)
									->with('episodes', $episodes)
									->renderSections();
        return $sections['episodesdetails'];
	}
	
	public function UpdateSerie(Request $request)
	{
		$data = json_decode($request->getContent(),true);

		Serie::where('imdbID', $data['originalID'])
				->update([
						"imdbID" => $data['imdbID'],
						"Title" => $data['Title'],
						"Year" => $data['Year'],
						"Rated" => $data['Rated'],
						"Released" => $data['Released'],
						"Runtime" => $data['Runtime'],
						"Director" => $data['Director'],
						"Writer" => $data['Writer'],
						"Actors" => $data['Actors'],
						"Plot" => $data['Plot'],
						"Language" => $data['Language'],
						"Country" => $data['Country'],
						"Awards" => $data['Awards'],
						"Poster" => $data['Poster'],
						"totalSeasons" => $data['totalSeasons'],
					]);
		$episodes = array();
		$serie = Serie::where('imdbID', $data['imdbID'])->first();
		$seasons = Episode::where('seriesID', $data['imdbID'])->groupBy('season')->get(['season']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $data['imdbID'])
													->where('season', $seasons[$key]->season)
													->get();
		}

		$sections = view('series.episodes')->with('serie', $serie)
									->with('seasons', $seasons)
									->with('episodes', $episodes)
									->renderSections();
        return $sections['episodesdetails'];
	}

	
	public function UpdateEpisode(Request $request)
	{
		$data = json_decode($request->getContent(),true);
	}
}
