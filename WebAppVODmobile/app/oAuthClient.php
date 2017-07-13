<?php

namespace SherifTube;

use Illuminate\Database\Eloquent\Model;

class oAuthClient extends Model
{
    protected $table = 'oauth_clients';

    protected $fillable = ['revoked'];

    public function CreateAuthClient ($client) 
    {
    	$oauth_client =  new $this;
    	$oauth_client->user_id = $client->id;
        $oauth_client->id = $client->id;
        $oauth_client->name = $client->email;
        $oauth_client->secret=base64_encode(hash_hmac('sha256',$client->password, 'secret', true));
        $oauth_client->password_client = 1;
        $oauth_client->personal_access_client = 0;
        $oauth_client->redirect = env("APP_URL");
        $oauth_client->revoked = 0;
        $oauth_client->save();
    }

    public function revokeClient ($clientid) 
    {
        $this::find($clientid)->update(['revoked' => 0]);
    }

    public function envokeClient ($clientid)
    {
        $this::find($clientid)->update(['revoked' => 1]);
    }

    public function deleteClient ($clientid)
    {
        $this::find($clientid)->delete();   
    }


}
