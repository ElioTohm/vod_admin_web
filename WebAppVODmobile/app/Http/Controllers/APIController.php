<?php

namespace SherifTube\Http\Controllers;

use Illuminate\Http\Request;
use SherifTube\Client;

class APIController extends Controller
{
    public function clientSignin (Request $request) 
    {
 		$data = json_decode($request->getContent(),true);
 		
 		// check if client is active
 		$result = Client::where('email', $data['usermail'])
	 					->first(['active']);
		if ($result === null) {
			return response()->json([
					'registered' => 0,
					'active' => 0
				]);
		} else {
			return response()->json([
					'registered' => 1,
					'active' => $result['active']
				]);
		} 

 		// return json_encode('{"test":"1"}');
 		return response()->json([
				    'name' => $data['usermail'],
				    'state' => 'CA'
				]);
 	}

 	public function clientRegister (Request $request)
 	{
 		$data = json_decode($request->getContent(),true);

 		$client = new Client();
 		$client->password = bcrypt($data['password']);
 		$client->email = $data['usermail'];
 		$client->active = 0;
 		$client->save();

 		return response()->json([
					'registered' => 1,
					'active' => 0
				]);
 	}
}
