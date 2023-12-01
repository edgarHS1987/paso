<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\States;
use App\Models\Municipalities;
use App\Models\Cities;
use App\Models\ZipCodes;
use App\Models\Colonies;
use App\Models\zones;

class MunicipalitiesController extends Controller
{
    
    /**
     * Obtiene listado de municipios para cargar en select
     */
    public function municipalities($stateId){
        $municipalities = Municipalities::select('id as value', 'name as label')
                            ->where('states_id', $stateId)
                            ->where('hasLocation', false)->get();

        return response()->json($municipalities);
    }

     /**
      * Obtiene listado de municipios
      */
    public function show($id){
        $municipalities = Municipalities::select('id', 'name')->where('states_id', $id)->orderBy('name', 'ASC')->get();

        foreach($municipalities as $municipality){
            $municipality['zip_codes'] = ZipCodes::join('colonies', 'colonies.zip_codes_id', 'zip_codes.id')
                                            ->where('zip_codes.municipalities_id', $municipality->id)
                                            ->selectRaw(
                                                'zip_codes.id as zip_code_id, zip_codes.zip_code, 
                                                colonies.id as colony_id, colonies.name, colonies.type'
                                            )->get();
                                                
        }

        return response()->json($municipalities);
    }

     /**
      * Actualiza datos de municipio, codigo postal, colonias y ciudades
      */
    public function update(Request $request){
        try{
            \DB::beginTransaction();

            $data = $request->all();

            foreach($data as $d){
                $municipalities = Municipalities::where('id', $d['municipalities_id'])->where('hasLocation', false)->first();
                if(isset($municipalities)){
                    $municipalities->hasLocation = true;
                    $municipalities->save();
                }

                $zipCodes = ZipCodes::where('id', $d['zip_code_id'])->first();
                if(isset($d['latitude'])){                    
                    $zipCodes->latitude = $d['latitude'];
                    $zipCodes->longitude = $d['longitude'];
                    $zipCodes->bbox = $d['bbox'];
                    $zipCodes->save();
                }else{
                    $zipCodes->delete();
                }
            }
            
            \DB::commit();

            return response()->json([
                'message'=>'Se guardaron los municipios correctamente'
            ]);
            
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage().' '.$e->getLine()]);
        }
    }

     /**
     * Verifica el numero total de codigos postales
     */
    public function verify(Request $request){
        $totalZipCodes = 0;

        $municipality = array();
        foreach($request->municipalities as $num => $mun){
            array_push($municipality, $mun);
        }
        
        $zipCodes = Municipalities::join('zip_codes', 'zip_codes.municipalities_id', 'municipalities.id')
                        ->where('states_id', $request->states_id)
                        ->whereIn('municipalities.id', $municipality)
                        ->where('zip_codes.latitude', '')
                        ->select('municipalities.id as municipality_id', 'zip_codes.id as zip_code_id', 'zip_codes.zip_code')
                        ->get();
        
        return response()->json($zipCodes);
     }


}
