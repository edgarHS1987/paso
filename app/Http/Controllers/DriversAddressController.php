<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\DriverAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class DriversAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        try {
            $request->validate([
                'drivers_id' => 'required',
                'street' => 'required',
                'ext_number' => 'required',
                'colony' => 'required',
                'state' => 'required',
                'municipality' => 'required',
                'zip_codes_id' => 'required'
            ]);

            $newAddress = DriverAddress::create($request->all());

            $statusCode = 201;
            $datos = [
                'message' => 'Driver Address Agregada',
                'statusCode' => $statusCode,
                'data' => $newDriver
            ];

            $Driver = new DriversController();
            $Driver->updateRFCDriver($request->drivers_id,$reques->rfc);

            return response()->json([$datos]);


        } catch (Exception $e) {
            $statusCode = 500;
            $datos = [
                'message' => 'Error Validacion ' . $e->getMessage(),
                'statusCode' => $statusCode,
                'error' => true,
                'data' => []
            ];

            return response()->json([$datos]);
        }      
    }


    public function edit($id){
        $driver = Driver::join('users', 'users.id', 'drivers.users_id')
                    ->where('drivers.id', $id)
                    ->select('drivers.id', 'drivers.names', 'drivers.lastname1','drivers.lastname2',
                                'drivers.status','users.email')->first();
        return response()->json($driver);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            \DB::beginTransaction();


            $driver = Driver::where('id', $id)->first();
            $driver->fill($request->all());
            $driver->save();
            \DB::commit();
            
            return response()->json([
                'ok' => true,
                'mensaje' => 'El driver '.$driver->names.' se actualizo correctamente.'
            ]);
            
        }catch(\Exception $e){
            \DB::rollback();
            //dd($e);
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage()]);
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
