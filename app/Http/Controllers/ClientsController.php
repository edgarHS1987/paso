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
            $storage = storage_path('app/public');
            $name = explode('.', $client->logo);
            $img_path = 'clients/'.$client->id.'/'.$name[0].'.png';
            $image = '';

            if(file_exists($storage.'/'.$img_path)){
                $image_content = Storage::disk('public')->get($img_path);    
                
                $image = 'data:image/png;base64,'.base64_encode($image_content);
            }

            $items[] = array(
                'id'=>$client->id, 
                'name'=>$client->name,
                'image'=>$image
            );
        }
        
        return response()->json($items);
    }

    public function list(){
        $clients = Clients::select('id as value', 'name as label')->get();

        return response()->json($clients);
    }
}
