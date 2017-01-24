<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class APIController extends Controller
{
    //
    public function test() 
    {
    	return User::all();
    }

    public function getClientAuthorization () 
    {
    	
    }
}
