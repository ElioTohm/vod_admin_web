<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Artist;

class ArtistController extends Controller
{
    /*
    * return index page for artists
    */
    public function Index ()
    {
    	$artists = Artist::get();
    	return view ('artists.artists')->with('artists', $artists);
    }

    /*
    * Add artists
    */
    public function AddArtist (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$artist = new Artist();
    	$artist->name = $data['artist_name'];
        $artist->image = $data['artist_image'];
    	$artist->save();

    	$artist = Artist::get();
    	$sections = view ('artists.artists')->with('artists', $artist)->renderSections();

    	return $sections['content'];
    }

    /*
    * Update artists
    */
    public function UpdateArtist (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$artist = Artist::find($data['artist_id']);
        if ($data['artist_name'] != "") {
        	$artist->name = $data['artist_name'];        
        }
        if ($data['artist_image']) {
            $artist->image = $data['artist_image'];
        }
    	$artist->save();

    	$artist = Artist::get();
    	$sections = view ('artists.artists')->with('artists', $artist)->renderSections();

    	return $sections['content'];
    }

    /*
    * Delete artists
    */
    public function DeleteArtist (Request $request)
    {
    	$data = json_decode($request->getContent(),true);

		Artist::where('id', $data['artist_id'])->delete();

        $response = array('deleted' => 'true');
        return json_encode($response);
    }
}
