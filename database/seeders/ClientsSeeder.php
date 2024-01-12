<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Clients;
use App\Models\Warehouses;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('clients')->delete();
        \DB::table('warehouses')->delete();
        \DB::table('clients_warehouses')->delete();

        $client = Clients::create([
            'name'=>'Estafeta',
            'logo'=>'estafeta.webp'
        ]);

        $warehouse = Warehouses::create([
            'name'=>'Bodega 1 - Estafeta'
        ]);

        \DB::table('clients_warehouses')->insert([
            'clients_id'=>$client->id,
            'warehouses_id'=>$warehouse->id
        ]);

    }
}
