<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Clients;

class WarehousesController extends Controller
{
    public function show($id){
        $warehouses = Clients::join('clients_warehouses', 'clients_warehouses.clients_id', 'clients.id')
                        ->join('warehouses', 'warehouses.id', 'clients_warehouses.warehouses_id')
                        ->selectRaw('warehouses.id as value, CONCAT(warehouses.name, " - ", clients.name) as label')
                        ->where('clients.id', $id)
                        ->get();

        return response()->json($warehouses);
    }
}
