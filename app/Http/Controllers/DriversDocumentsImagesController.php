<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\User;
use App\Models\DriverDocument;
use App\Models\DriverDocumentImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Exception;

class DriversDocumentsImagesController extends Controller
{

    public function readFilesinPath( string $path,string $id ){
        $image = new DriversDocumentsImagesController();

        // Get all files in the specified directory
        $files = Storage::files( $path );

        // Loop through each file and read its content
        foreach ($files as $file) {
            // Get the file content
            $content = Storage::get($file);

            //save names in table
            $image->store( $id,$file );

            // Process or display the content as needed
            // echo "File: $file<br>";
            // echo "Content: $content<br>";
            // echo "<hr>";
        }
    }

    public function clearFilesinPath( string $path ){
        $image = new DriversDocumentsImagesController();

        // Get all files in the specified directory
        $files = Storage::files( $path );

        // Loop through each file and read its content
        foreach ($files as $file) {

            //save names in table
            Storage::delete( $file );

        }
    }

    /**
     * Upload Document
     */
    public function subir( Request $request ){

       
        
    }



    /**
     * get Documents in storage
     */
    public function download(){

        // $statusCode = 201;
        // $datos = [
        //     'message' => 'Documentos Agregados',
        //     'statusCode' => $statusCode,
        //     'error' => false
        // ];

        //return response()->json([$datos]);
        $disk = Storage::disk('local');
        return Storage::temporaryUrl( '929160613601 (1).pdf' , now()->addMinutes(5));

        // Specify the path to the file within the storage directory
        $path = 'drivers-doc\driver_0\Licencia';

        // Get all files in the specified directory
        $files = Storage::files( $path );

        // Loop through each file and read its content
        foreach ($files as $file) {
            // Get the file content
            $content = Storage::get($file);

            return response()->json([$content]);
        }

        // Check if the file exists
        if (Storage::exists($path)) {
            // Return the file as a response
            return response()->file(storage_path($path));
        } else {
            // If the file doesn't exist, return a 404 response or handle it accordingly
            return response()->json(['error' => 'File not found'], 404);
        }
        
    }

    //Obtener documentos cargados en la ruta
    public function listDocuments( string $tipo, string $id){
        $image = new DriversDocumentsImagesController();
        
        $rutaDriver = '';

        if ( $tipo == 'Identificacion Oficial' ) {
            $rutaDriver = 'driver_' .  $id . '/INE/';    
        }elseif (  $tipo == 'Licencia Conducir' ) {
            $rutaDriver = 'driver_' .  $id . '/Licencia/';
        }elseif (  $tipo == 'Comprobante Domicilio' ) {
            $rutaDriver = 'driver_' .  $id . '/Comprobante/';
        }elseif (  $tipo == 'Constancia Situacion Fiscal' ) {
            $rutaDriver = 'driver_' .  $id . '/SAT/';
        }
        
        $files = Storage::disk('docsDrivers')->files( $rutaDriver );
        
        $allFiles = [];
        foreach ($files as $file) {
            $nombreFile = pathinfo($file,PATHINFO_BASENAME);
            $data['name'] = pathinfo($file,PATHINFO_BASENAME);
            // $data['url'] = Storage::disk('docsDrivers')->response( $rutaDriver . $nombreFile );
            array_push( $allFiles,$data );

        }

        return response()->json([$allFiles]);
    }


    public function getDoc( string $path, string $tipo, string $id ){

        if ( $tipo == 'Identificacion Oficial' ) {
            $rutaDriver = 'driver_' .  $id . '/INE/';    
        }elseif (  $tipo == 'Licencia Conducir' ) {
            $rutaDriver = 'driver_' .  $id . '/Licencia/';
        }elseif (  $tipo == 'Comprobante Domicilio' ) {
            $rutaDriver = 'driver_' .  $id . '/Comprobante/';
        }elseif (  $tipo == 'Constancia Situacion Fiscal' ) {
            $rutaDriver = 'driver_' .  $id . '/SAT/';
        }

        $pathFile = $rutaDriver . $path; 
        
        abort_if(   
            ! Storage::disk('docsDrivers') ->exists($pathFile),
            404,
            "The file doesn't exist. Check the path."
        );
         return Storage::disk('docsDrivers')->response($pathFile);
        //return Storage::disk('docsDrivers')->get($pathFile);
    }



    /**
     * Store detail about Driver's document
     */
    public function store( string $idDoc, string $nameFile)
    {   
        try {

            $data = [
                'drivers_document_id' => $idDoc,
                'name' => $nameFile,
            ];

            $image = DriverDocumentImage::create($data);

            $statusCode = 201;
            $datos = [
                'message' => 'Driver documents images added',
                'statusCode' => $statusCode,
                'error' => false
            ];

            return response()->json([$datos]);


        } catch (Exception $e) {
            $statusCode = 500;
            $datos = [
                'message' => 'Error ' . $e->getMessage(),
                'statusCode' => $statusCode,
                'error' => true,
            ];

            return response()->json([$datos]);
        }      
        
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
    public function update( Request $request,string $id )
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DriverDocumentImage::where('drivers_document_id', $id)->delete();
    }
}
