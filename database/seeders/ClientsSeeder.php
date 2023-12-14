<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Clients;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('clients')->delete();

        $client = Clients::create([
            'name'=>'Estafeta',
            'logo'=>'estafeta.webp'
        ]);
    }
}
