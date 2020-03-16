<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\Client as ClientResource;

class ClientController extends Controller
{
    public function showLatestPayments(){
        
        
        $clients= new ClientCollection(Client::all());
        
        return view('clients')->with('clients',$clients);
        // return $clients;
    }
}
