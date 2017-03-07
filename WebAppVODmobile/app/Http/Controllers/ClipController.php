<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Http\Requests;
use SherifTube\Clip;
use SherifTube\Genre;
use SherifTube\ClipGenre;
use GuzzleHttp\Client;
use Intervention\Image\Facades\Image;


class ClipController extends Controller
{
    public function index () 
    {
    	$Clips = Clip::orderBy('Title', 'asc')->paginate(12);
        $allgenres = \DB::table('genres')
                        ->get(['genres.genre_name']);
    	return view('clips.clips')->with('clips', $Clips)
    							  ->with('allgenres', $allgenres);
    }

    public function RemoveClip (Request $request)
    {
        $data = json_decode($request->getContent(),true);
        
        $clip = new Clip();

        //uses Model function to delete
        $clip->DeleteClip($data['id']);

        return $data['id'];
    }

    public function addClip (Request $request)
    {
        $data = json_decode($request->getContent(),true);

        $imdbID = hash('md5', $data['Title']);

        $clip = new Clip();
        $clip->Title = $data['Title'];
        $clip->Poster = env('APP_URL'). 'videos/clips_posters/' .$data['Poster'];
        $clip->stream = $data['Stream'];
        $clip->Subtitle = $data['Subtitle'];
        $clip->save();

        $this->checkGenreExists($data['Genre'], $clip->id);
        
        $Clips = Clip::orderBy('Title', 'asc')->paginate(12);  
        $allgenres = \DB::table('genres')
                    ->get(['genres.genre_name']);
    
        $sections =  view('clips.clips')->with('clips', $Clips)
								        ->with('allgenres', $allgenres)
								        ->renderSections(); 
       
        return $sections['clip_list'];
    }

    private function checkGenreExists ($genrearray, $id) {
        $genrenumber = array();
       
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

        $this->AddClipGenreRelation ($genrenumber,$id);   
    }

    private function AddClipGenreRelation ($genrearray,$id)
    {
        ClipGenre::where('id', $id)->delete();
        foreach ($genrearray as $key => $value) {
            $clipgenre = new ClipGenre();
            $clipgenre->id = $id;
            $clipgenre->genre_id = $value;
            $clipgenre->save();   
        }
    }

    public function UpdateClip (Request $request) 
    {
    	$data = json_decode($request->getContent(),true);
        
        $this->checkGenreExists($data['Genre'], $data['id']);

        if(!empty($data['Stream'])) {
            Clip::where('id', $data['id'])
                ->update([
                        'Title' => $data['Title'],
                        'Poster' => env('APP_URL'). 'videos/clips_posters/' . $data['Poster'],
                        'stream' => $data['Stream'],
                        'Subtitle' => $data['Subtitle'],
                    ]);
        } else {
            Clip::where('id', $data['id'])
                ->update([
                        'Title' => $data['Title'],
                        'Poster' => env('APP_URL'). 'videos/clips_posters/' . $data['Poster'],
                        'Subtitle' => $data['Subtitle'],
                    ]);
        }

        $Clips = Clip::orderBy('Title', 'asc')->paginate(12);  
        $allgenres = \DB::table('genres')
                    ->get(['genres.genre_name']);
    
        $sections =  view('clips.clips')->with('clips', $Clips)
								        ->with('allgenres', $allgenres)
								        ->renderSections(); 
       
        return $sections['clip_list'];

    }

    public function getClipInfo (Request $request)
    {
		$data = json_decode($request->getContent(),true);
		$clip = Clip::find($data['id']);
		$genres = \DB::table('clip_genres')->where('id', $data['id'])
                        ->join('genres', 'genres.genre_id', '=', 'clip_genres.genre_id')
                        ->groupBy('clip_genres.genre_id')
                        ->pluck('genres.genre_name');

		return response()->json([
					'clip' => $clip,
					'genres' => $genres,
				]);
    }

}

