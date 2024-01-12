<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Clients;
use App\Models\ZipCodes;
use App\Models\Zones;
use App\Models\ZonesZipCodes;

class ZonesController extends Controller
{

    public function byClient($id){
        $zones = Zones::select('id', 'name')->where('clients_id', $id)->where('isLast', true)->get();

        $zones->each(function($z){
            $z['zip_codes'] = ZipCodes::join('zones_zip_codes', 'zones_zip_codes.zip_codes_id', 'zip_codes.id')
                                    ->join('zones', 'zones.id', 'zones_zip_codes.zones_id')
                                    ->join('colonies', 'colonies.zip_codes_id', 'zip_codes.id')
                                    ->select('zip_codes.id', 'zip_codes.zip_code', 'colonies.name as colony')
                                    ->where('zones_zip_codes.zones_id', $z->id)
                                    ->get();
        });

        return response()->json($zones);
    }

    public function configuring(Request $request){
        try{
            \DB::beginTransaction();

            $zones = Zones::where('clients_id', $request->clients_id)->where('isLast', true)->get();
            $zones->each(function($z){
                $z->isLast = false;
                $z->save();
            });

            $zip_codes = ZipCodes::join('municipalities', 'municipalities.id', 'zip_codes.municipalities_id')
                            ->where('municipalities.name', 'San Luis Potosí')
                            ->orWhere('municipalities.name', 'SSoledad de Graciano Sánchez')
                            ->select('zip_codes.id', 'zip_codes.zip_code')
                            ->get();
            
            $totalZone = round(count($zip_codes) / $request->numberZones);
            
            $countZone = 0;
            for($i = 0; $i < $request->numberZones; $i++){
                $zone = new Zones();
                $zone->clients_id = $request->clients_id;
                $zone->name = 'Zona '.($i + 1);
                $zone->isLast = true;
                $zone->save();

                for($j = 0; $j < $totalZone; $j++){
                    if($countZone <= count($zip_codes) - 1){
                        $zoneZipCode = new ZonesZipCodes();
                        $zoneZipCode->zones_id = $zone->id;
                        $zoneZipCode->zip_codes_id = $zip_codes[$countZone]['id'];
                        $zoneZipCode->save();                        
                    }

                    $countZone++;
                }
            }

            \DB::commit();
            
            return response()->json([
                'message'=>'Se realizo la configuración de zonas correctamente'
            ]);

        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage().' '.$e->getLine()]);
        }
    }

    public function verifyIfExist(Request $request){
        $zones = Zones::where('clients_id', $request->clients_id)->where('isLast', true)->get();

        if(count($zones) > 0){
            return response()->json([
                'error'=>'Ya existen zonas configuradas para el cliente seleccionado, ¿Desea realizar una nueva configuración?'
            ]);
        }

        return response()->json([
            'ok'=>true
        ]);
    }
}
