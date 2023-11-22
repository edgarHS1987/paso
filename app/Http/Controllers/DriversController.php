<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // try{
        //     \DB::beginTransaction();



        //     \DB::commit();

        //     return response()->json([
        //         'ok' => 'registro correcto',                
        //         'sales_id' => $sales->id
        //     ]);


        // }catch(\Exception $e){
        //     \DB::rollback();
        //     //dd($e);
        //     return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage().' '.$e->getLine()]);
        // }

        $allResidentes = Residente::all();
        try {
            $statusCode = 200;
            return response()->json([
                'message' => 'Lista de Residentes',
                'statusCode' => $statusCode,
                'error' => true,
                'data' => $allResidentes
            ],$statusCode);
            
        } catch(Exception $e){

            $statusCode = 500;
            return response()->json([
                'message' => 'Lista de Residentes - Error ' . $e,
                'statusCode' => $statusCode,
                'error' => false,
                'data' => []
            ],$statusCode);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        
        try {
            $request->validate([
                'names' => 'required',
                'lastname1' => 'required',
                'phone' => 'required',
                'status' => 'required',
                //'email'=> 'unique:residentes',
            ]);

            $newDriver = Driver::create($request->all());


            $statusCode = 201;
            return response()->json([
                'message' => 'Driver Agregado',
                'statusCode' => $statusCode,
                'error' => true,
                'data' => $newDriver
            ],$statusCode);

        } catch (Exception $e) {
            $statusCode = 500;
            return response()->json([
                'message' => 'Error Validacion ' . $e->getMessage(),
                'statusCode' => $statusCode,
                'error' => true,
                'data' => []
            ],$statusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        try {

            $residente = Residente::findOrFail($id);
            echo $residente->created_at;


            $statusCode = 200;
            return response()->json([
                'message' => 'Residente Encontrado',
                'statusCode' => $statusCode,
                'error' => true,
                'data' => $residente
            ],$statusCode);
            
        } catch(ModelNotFoundException $e){

            $statusCode = 500;
            return response()->json([
                'message' => 'Error al obtener Residente - Error ' . $e->getMessage(),
                'statusCode' => $statusCode,
                'error' => false,
                'data' => []
            ],$statusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
