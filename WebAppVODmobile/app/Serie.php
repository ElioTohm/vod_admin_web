<?php

namespace SherifTube;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    //delete Series by imdb key
 	function DeleteSeries ($imdbID) 
 	{
 		Serie::where('imdbID',$imdbID)
            ->delete();
 	}

 	//one2many relation for serie and episode table
 	function episodes ()
 	{
 		return $this->hasMany('SherifTube\Episode', 'seriesID', 'imdbID');
 	}
}
