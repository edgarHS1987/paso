<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Clients;

class ClientsController extends Controller
{
    public function getImageFromStorage(){

    }

    public function index(){
        $clients = Clients::all();

        $items = array();
        foreach($clients as $client){
            
            $path = 'clients/'.$client->id.'/estafeta.png';
            $image_content = Storage::disk('public')->get($path);
            
            $image = 'data:image/png;base64,'.base64_encode($image_content);

            $items[] = array(
                'id'=>$client->id, 
                'name'=>$client->name,
                'image'=>$image
            );
        }
        
        return response()->json($items);
    }
}
