<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;

use SherifTube\Client;

class ClientsController extends Controller
{
    public function index ()
    {	
    	$clients = Client::where('active', 0)->paginate(15);

    	return view('clients.clients')->with('clients', $clients)
    								->with('active', 0);
    }

    public function activeclient ()
    {
    	$clients = Client::where('active', 1)->paginate(15);

    	return view('clients.clients')->with('clients', $clients)
    								->with('active', 1);
    }

    public function activate (Request $request)
    {	
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to activate
        $client->ActivateClient($data['clientID']);

        return $data['clientID'];
    }

    public function delete (Request $request)
    {	
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to delete
        $client->DeleteClient($data['clientID']);

        return $data['clientID'];
    }

    public function deactivate(Request $request)
    {
    	$data = json_decode($request->getContent(),true);

    	$client = new Client();

        //uses Model function to delete
        $client->DeactivateClient($data['clientID']);

        return $data['clientID'];
    }

}
