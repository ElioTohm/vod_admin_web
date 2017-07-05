<?php

namespace SherifTube;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'clients';
    protected $fillable = ['active'];

    //activate Client by id
 	function ActivateClient () 
 	{
 		$this->update(['active' => 1]);
 	}

 	//deactivate client by id
 	function DeactivateClient ($client_id)
 	{
 		Client::where('id',$client_id)
            ->update(['active' => 0]);	
 	}

 	//delete Client by id
 	function DeleteClient ($client_id) 
 	{
 		Client::where('id',$client_id)
            ->delete();
 	}

 	public function findForPassport($username) {
		return $this->whereEmail($username)->first();
	}
 	
}
