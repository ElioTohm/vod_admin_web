<?php

namespace SherifTube;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'clients';

    //activate Client by id
 	function ActivateClient ($client_id) 
 	{
 		Client::where('client_id',$client_id)
            ->update(['active' => 1]);
 	}

 	//deactivate client by id
 	function DeactivateClient ($client_id)
 	{
 		Client::where('client_id',$client_id)
            ->update(['active' => 0]);	
 	}

 	//delete Client by id
 	function DeleteClient ($client_id) 
 	{
 		Client::where('client_id',$client_id)
            ->delete();
 	}
 	
}
