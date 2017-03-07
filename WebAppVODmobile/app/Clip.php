<?php

namespace SherifTube;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
   protected $table = 'clips';

 	//delete Movies by imdb key
 	function DeleteClip ($id) 
 	{
 		Clip::where('id',$id)
            ->delete();
 	}
}
