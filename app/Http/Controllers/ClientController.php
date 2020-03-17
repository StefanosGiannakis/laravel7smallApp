<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientCollection;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function showLatestPayments(){

        $clients = new ClientCollection(Client::all());
        return view('clients')->with('clients',json_decode(json_encode($clients)));
    }

    public function searchLatestPayments(Request $request){
        
        $dates = $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date'
        ]);

        $clients = new Client();
        
        return $clients->getLatestPaymentsByDates($dates);    
    }
}
