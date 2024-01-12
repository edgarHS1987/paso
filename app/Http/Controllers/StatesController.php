<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\States;
use App\Models\Municipalities;
use App\Models\ZipCodes;
use App\Models\Colonies;

class StatesController extends Controller
{

    public function index(){
        $states = States::select('id', 'name')->orderBy('name', 'ASC')->get();

        return response()->json($states);
    }

    /**
     * Obtiene listado de estados
     */
    public function states(){
        $states = States::select('id as value', 'name as label')->get();

        return response()->json($states);
    }

    /**
     * Verifica si el estado ya se registro
     */
    public function verify(Request $request){
        $states = $request->all();

        $totalStates = count($states);
        $registeredStates = 0;

        foreach($states as $st){
            $state = States::where('name', $st['name'])->get();

            if(count($state) > 0){
                $registeredStates++;
            }
        }

        if($totalStates == $registeredStates){
            return response()->json([
                'error'=>'Los estados ya se encuentran registrados'
            ]);
        }

        return response()->json(['ok'=>true]);
    }

    /**
     * Guarda datos de todos los estados
     * El guardado no incluye latitud y longitud
     */
    public function store(Request $request){
        try{
            \DB::beginTransaction();

            $state = new States();
            $state->name = $request->name;
            $state->save();

            foreach($request->municipalities as $municipality){
                $municipalities = new Municipalities();
                $municipalities->states_id = $state->id;
                $municipalities->name = $municipality['name'];
                $municipalities->save();

                foreach($municipality['zip_codes'] as $zip){
                    $zipCodes = new ZipCodes();
                    $zipCodes->municipalities_id = $municipalities->id;
                    $zipCodes->zip_code = $zip['zip_code'];
                    $zipCodes->save();

                    foreach($zip['colonies'] as $colony){
                        $colonies = new Colonies();
                        $colonies->zip_codes_id = $zipCodes->id;
                        $colonies->name = $colony['name'];
                        $colonies->type = $colony['type'];
                        $colonies->save();
                    }
                }
            }

            \DB::commit();
            
            return response()->json([
                'ok'=>true
            ]);

        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage().' '.$e->getLine()]);
        }
    }
}
