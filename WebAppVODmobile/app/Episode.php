<?php

namespace SherifTube;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';


    function deleteEpisode ($imdbID)
    {
    	Episode::where('imdbID',$imdbID)
            ->delete();
    }
}
