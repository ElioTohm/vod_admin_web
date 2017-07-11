<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;

use SherifTube\Client;

use SherifTube\oAuthClient;


class ClientsController extends Controller
{
    private $ITEMPERPAGE = 3;

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

        //create Oauth client for the client
        // $oauth_client = new oAuthClient();
        // $oauth_client->CreateAuthClient($client);

        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    public function delete (Request $request)
    {	
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to delete
        $client->DeleteClient($data['clientID']);

        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    public function deactivate(Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to delete
        $client->DeactivateClient($data['clientID']);

        return $this->getclientsfrompage($data['currentpage'], $data['condition']);
    }

    private function getclientsfrompage ($page, $condition) 
    {
        $clients = Client::where('active', $condition)->offset(($page - 1 )*$this->ITEMPERPAGE)->limit($this->ITEMPERPAGE)->get();

        return $clients;
    }
}
