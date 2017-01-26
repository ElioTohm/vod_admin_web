<?php

namespace SherifTube;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
 	protected $table = 'movies';

 	//delete Movies by imdb key
 	function DeleteMovie ($imdbID) 
 	{
 		Movie::where('imdbID',$imdbID)
            ->delete();
 	}

}
