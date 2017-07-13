<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;

use SherifTube\Client;

use SherifTube\oAuthClient;


class ClientsController extends Controller
{
    private $ITEMPERPAGE = 15;

    public function clientindex ()
    {	
    	$clients = Client::where('active', 0)->paginate($this->ITEMPERPAGE);

    	return view('clients.clients')->with('clients', $clients)
    								->with('active', 0);
    }

    public function activeclientindex ()
    {
    	$clients = Client::where('active', 1)->paginate($this->ITEMPERPAGE);

    	return view('clients.clients')->with('clients', $clients)
    								->with('active', 1);
    }

    public function activate (Request $request)
    {	
    	$data = json_decode($request->getContent(),true);

    	$client = Client::find($data['clientID']);

        //uses Model function to activate
        $client->ActivateClient();

        $oauth_client = new oAuthClient();

        //check if oAuthClient exists
        if (is_null(oAuthClient::find($data['clientID']))) {
            //create Oauth client for the client
            $oauth_client->CreateAuthClient($client);
        } else {
            $oauth_client->revokeClient($data['clientID']);
        }

        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    public function delete (Request $request)
    {	
    	$data = json_decode($request->getContent(),true);

        if (!is_null(oAuthClient::find($data['clientID']))) {
            $oauth_client = new oAuthClient();
            $oauth_client->deleteClient($data['clientID']);
        }

        //uses Model function to delete
        $client = new Client();
        $client->DeleteClient($data['clientID']);
        
        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    public function deactivate(Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to delete
        $client->DeactivateClient($data['clientID']);

        //envoke oAuthclient
        $oauth_client = new oAuthClient();
        $oauth_client->envokeClient($data['clientID']);

        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    private function getclientsfrompage ($page, $condition) 
    {
        $clients = Client::where('active', $condition)->offset(($page - 1 )*$this->ITEMPERPAGE)->limit($this->ITEMPERPAGE)->get();

        return $clients;
    }
}
