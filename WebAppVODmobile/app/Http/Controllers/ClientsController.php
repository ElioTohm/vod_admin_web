<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;

use SherifTube\Client;

class ClientsController extends Controller
{
    public function index ()
    {	
    	$clients = Client::paginate(15);
    	return view('clients.clients')->with('clients', $clients);
    }

    public function activate (Request $request)
    {	
    	$client = new Client();

        //uses Model function to activate
        $client->ActivateClient($data['clientID']);

        return $data['clientID'];
    }

    public function delete (Request $request)
    {	
    	$client = new Client();

        //uses Model function to delete
        $client->DeleteClient($data['clientID']);

        return $data['clientID'];
    }
}
