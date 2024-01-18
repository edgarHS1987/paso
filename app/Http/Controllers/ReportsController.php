<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\ServiceDriver;
use App\Models\DriverSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ReportsController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function workDays( string $fecha1, string $fecha2 )
    {   
        $allDriversSchedule = DriverSchedule::
                    join('drivers', 'drivers.id', 'drivers_schedule.drivers_id')
                    ->whereBetween('date', [$fecha1, $fecha2])
                    ->select('drivers.id', 'drivers_schedule.date', 'drivers.lastname1',
                            'drivers.names','drivers.lastname2','drivers.lastname2')
                    ->get();

        try {
            $statusCode = 200;
            return response()->json([
                'message' => 'Lista de Drivers_Schedule',
                'statusCode' => $statusCode,
                'error' => false,
                'data' => $allDriversSchedule,
            ],$statusCode);
            
        } catch(Exception $e){
            
            $statusCode = 500;
            return response()->json([
                'message' => 'Lista de Drivers_Schedule - Error ' . $e,
                'statusCode' => $statusCode,
                'error' => true,
                'data' => []
            ],$statusCode);
        }
        
    }

    public function servicesAsigned( string $fecha1, string $fecha2 ){

        $results = ServiceDriver::join('services', 'services_drivers.services_id', '=', 'services.id')
            ->join('drivers', 'services_drivers.drivers_id', '=', 'drivers.id')
            ->select(
                'services.id as id',
                'services.date as fechaAltaServicio',
                'services.time as horaAltaServicio',
                'services.guide_number as guia',
                'services.zip_code as zip',
                'services.assigned',
                'services_drivers.drivers_id',
                'services_drivers.date as fechaAsignacion',
                'services_drivers.time as horaAsignacion',
                'drivers.names as names',
                'drivers.lastname1 as lastname1',
                'drivers.lastname2 as lastname2',
                'services_drivers.status as status'
            )
            ->whereBetween('services_drivers.date', [$fecha1, $fecha2])
            ->get();

        try {
            $statusCode = 200;
            return response()->json([
                'message' => 'Lista de Servicios Asignados',
                'statusCode' => $statusCode,
                'error' => false,
                'data' => $results,
            ],$statusCode);
            
        } catch(Exception $e){

            $statusCode = 500;
            return response()->json([
                'message' => 'Lista de Servicios Asignados - Error ' . $e,
                'statusCode' => $statusCode,
                'error' => true,
                'data' => []
            ],$statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
