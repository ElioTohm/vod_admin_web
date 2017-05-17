<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Http\Requests;

use SherifTube\Clip;
use SherifTube\Genre;
use SherifTube\ClipGenre;
use SherifTube\Artist;

use GuzzleHttp\Client;
use Intervention\Image\Facades\Image;


class ClipController extends Controller
{
    public function index ($artist_id) 
    {
    	if ($artist_id == 0) {
            $Clips = Clip::orderBy('Title', 'asc')->paginate(12);
            $artist = Artist::where('id', $artist_id)->first(['image', 'name', 'id']);
            return view('clips.clips')->with('clips', $Clips)
                                      ->with('artist', $artist);
        } else {
            $Clips = Clip::where('artist_id', $artist_id)->orderBy('Title', 'asc')->paginate(12);
            $artist = Artist::where('id', $artist_id)->first(['image', 'name', 'id']);
            return view('clips.clips')->with('clips', $Clips)
                                      ->with('artist', $artist);

        }
        
        
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

        $clip = new Clip();
        $clip->Title = $data['Title'];
        $clip->stream = $data['Stream'];
        $clip->artist_id = $data['Artist_id'];
        $clip->Subtitle = $data['Subtitle'];
        $clip->save();

        $Clips = Clip::where('artist_id', $data['Artist_id'])->orderBy('Title', 'asc')->paginate(12);  
        $artist = Artist::where('id', $data['Artist_id'])->first(['image', 'name', 'id']);
        $sections =  view('clips.clips')->with('clips', $Clips)
                                        ->with('artist', $artist)
								        ->renderSections(); 

        return $sections['clip_list'];
    }


    public function UpdateClip (Request $request) 
    {
    	$data = json_decode($request->getContent(),true);
        
        if(!empty($data['Stream'])) {
            Clip::where('id', $data['id'])
                ->update([
                        'Title' => $data['Title'],
                        'stream' => $data['Stream'],
                        'Subtitle' => $data['Subtitle'],
                    ]);
        } else {
            Clip::where('id', $data['id'])
                ->update([
                        'Title' => $data['Title'],
                        'Subtitle' => $data['Subtitle'],
                    ]);
        }

        $Clips = Clip::where('artist_id', $data['Artist_id'])->orderBy('Title', 'asc')->paginate(12);  
        $artist = Artist::where('id', $data['Artist_id'])->first(['image', 'name', 'id']);
        $sections =  view('clips.clips')->with('clips', $Clips)
                                        ->with('artist', $artist)
								        ->renderSections(); 
       
        return $sections['clip_list'];

    }


    public function MultiClip (Request $request)
    {
        $data = json_decode($request->getContent(),true);

        $response = array();

        foreach ($data['Stream'] as $key => $value) {
            $clip = new Clip();
            $clip->stream = $value;
            $clip->Title = substr($value, 0, strripos($value, "."));;
            $clip->artist_id = $data['Artist_id'];
            $clip->save();

            array_push($response, $value);
        }

        $Clips = Clip::where('artist_id', $data['Artist_id'])->orderBy('Title', 'asc')->paginate(12);  
        $artist = Artist::where('id', $data['Artist_id'])->first(['image', 'name', 'id']);
        $sections =  view('clips.clips')->with('clips', $Clips)
                                        ->with('artist', $artist)
								        ->renderSections(); 

        return $sections['clip_list'];
    }

    public function getClipInfo (Request $request)
    {
		$data = json_decode($request->getContent(),true);
		$clip = Clip::find($data['id']);
		return response()->json([
					'clip' => $clip,
				]);
    }
}

