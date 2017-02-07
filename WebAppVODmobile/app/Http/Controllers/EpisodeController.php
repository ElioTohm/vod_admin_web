<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Serie;
use SherifTube\Episode;
use SherifTube\SerieGenre;
use SherifTube\Genre;
use Intervention\Image\Facades\Image;
use GuzzleHttp\Client;

class EpisodeController extends Controller
{
    public function index ($imdbID)
    {
    	$episodes = array();
    	$serie = Serie::where('id', $imdbID)->first();
    	$genres = \DB::table('serie_genres')->where('id', $serie->id)
                        ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
                        ->groupBy('serie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
		$seasons = Episode::where('seriesID', $serie->id)->groupBy('season')->get(['season']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $serie->id)
														->where('season', $seasons[$key]->season)
														->get();
		}
		
    	return view('series.episodes')->with('serie', $serie)
    									->with('seasons', $seasons)
    									->with('episodes', $episodes)
    									->with("allgenres", $allgenres)
    									->with('genres', $genres); 
    }

    public function addEpisode (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$result = $this->imdbAPIRequest($data['imdbID']);

 		$info = json_decode($result, true);

 		if ($info['Response'] == "True" && $info['Type'] == "episode") {
            
            //convert string to date
 			$date = strtotime($info['Released']);
			$image = Image::make($info['Poster'])->encode('jpg', 80)->save(public_path('videoimages/'. $info['imdbID'] .'.png'));
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
			$episode->Poster = \Config::get('app.base_url').'videoimages/'. $info['imdbID'] .'.png';
			$episode->Metascore = (int)$info['Metascore'];
			$episode->imdbRating = $info['imdbRating'];
			$episode->imdbVotes = $info['imdbVotes'];
			$episode->Type = $info['Type'];
			$episode->seriesID = $data['seriesID'];
			$episode->stream = $data['stream'];
          	$episode->save();
           

			$episodes = array();
			$serie = Serie::where('id', $data['seriesID'])->first();
			$seasons = Episode::where('seriesID', $data['seriesID'])->groupBy('season')->get(['season']);
			$genres = \DB::table('serie_genres')->where('id', $serie->id)
                        ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
                        ->groupBy('serie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
	        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
			foreach ($seasons as $key => $value) {
				$episodes[$seasons[$key]->season] = Episode::where('seriesID', $data['seriesID'])
														->where('season', $seasons[$key]->season)
														->get();
			}

			$sections = view('series.episodes')->with('serie', $serie)
										->with('seasons', $seasons)
										->with('episodes', $episodes)
										->with("allgenres", $allgenres)
    									->with('genres', $genres)
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
		$episode->imdbID = hash('md5', $data['Title']);
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
		$episode->Poster = 'N/A';
		$episode->Metascore = 0;
        $episode->imdbRating = 0.0;
        $episode->imdbVotes = 'N/A';
		$episode->Type = 'episode';
		$episode->seriesID = $data['seriesID'];
		$episode->stream = $data['Stream'];
      	$episode->save();
       

		$episodes = array();
		$serie = Serie::where('id', $data['seriesID'])->first();
		$seasons = Episode::where('seriesID', $serie->id)->groupBy('season')->get(['season']);
		$genres = \DB::table('serie_genres')->where('id', $serie->id)
                        ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
                        ->groupBy('serie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $serie->id)
														->where('season', $seasons[$key]->season)
														->get();
		}

		$sections = view('series.episodes')->with('serie', $serie)
									->with('seasons', $seasons)
									->with('episodes', $episodes)
									->with('allgenres', $allgenres)
									->with('genres', $genres)
									->renderSections();
        return $sections['episodesdetails'];
	}
	
	public function UpdateSerie(Request $request)
	{

		
		$data = json_decode($request->getContent(),true);
		$id = $data['id'];

		$this->checkGenreExists($data['Genre'], $data['id']);

		Serie::where('id', $id)
				->update([	
						"imdbID" => hash('md5', $data['Title']),
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
		$serie = Serie::where('id', $id)->first();
		$seasons = Episode::where('seriesID', $id)->groupBy('season')->get(['season']);
		$genres = \DB::table('serie_genres')->where('id', $serie->id)
                        ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
                        ->groupBy('serie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $id)
													->where('season', $seasons[$key]->season)
													->get();
		}

		$sections = view('series.episodes')->with('serie', $serie)
									->with('seasons', $seasons)
									->with('episodes', $episodes)
									->with('allgenres', $allgenres)
									->with('genres', $genres)
									->renderSections();
        return $sections['episodesdetails'];
	}

	
	public function UpdateEpisode(Request $request)
	{
		$data = json_decode($request->getContent(),true);

		Episode::where('id', $data['imdbID'])
				->update([
						'Title' => $data['Title'],
						'stream' => $data['Stream'],
					]);

		$episodes = array();
		$serie = Serie::where('id', $data['seriesID'])->first();
		$seasons = Episode::where('seriesID', $data['seriesID'])->groupBy('season')->get(['season']);
		$genres = \DB::table('serie_genres')->where('id', $serie->id)
                        ->join('genres', 'genres.genre_id', '=', 'serie_genres.genre_id')
                        ->groupBy('serie_genres.genre_id')
                        ->get(['genres.genre_name', 'genres.genre_id']);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
		foreach ($seasons as $key => $value) {
			$episodes[$seasons[$key]->season] = Episode::where('seriesID', $data['seriesID'])
													->where('season', $seasons[$key]->season)
													->get();
		}

		$sections = view('series.episodes')->with('serie', $serie)
									->with('seasons', $seasons)
									->with('episodes', $episodes)
									->with("allgenres", $allgenres)
									->with('genres', $genres)
									->renderSections();
        return $sections['episodesdetails'];
	}

	public function UploadSeriePoster(Request $request)
	{
		$id = $request->get('serieid');

        if ($request->hasFile('PosterUpload')) {
            $this->validate($request, [
                'PosterUpload' => 'image|mimes:jpeg,png,png',
            ]);
            $poster = $request->file('PosterUpload');
            $poster->move(public_path('videoimages/'), $poster->getClientOriginalName());

            Serie::where('id', $id)
                ->update([
                        'Poster' => \Config::get('app.base_url').'videoimages/'. $poster->getClientOriginalName(),
                    ]);
        } else {
            return "no file was uploaded";
        }
        $serie = Serie::where('id', $id)->first();
        return redirect()->back();
	}

	private function checkGenreExists ($genre, $imdbID) {
        $genrenumber = array();
       
        //foreach genre in array check if genre exists
        foreach ($genre as $key => $value) {
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

        //return id to be added in array
        return $genre->genre_id;
    }

    /**
     * AddMovieSerieRelation takes array of genres numbers and add them with the 
     * corresponding movie imdb to this is done to fill the many-to-many table
     **/
    private function AddSerieGenreRelation ($genrearray,$imdbID)
    {
        SerieGenre::where('id', $imdbID)->delete();
        foreach ($genrearray as $key => $value) {
            $seriegenre = new SerieGenre();
            $seriegenre->id = $imdbID;
            $seriegenre->genre_id = $value;
            $seriegenre->save();   
        }

    }
}
