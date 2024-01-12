<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Sites;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->delete();        
        
        $user = User::create([
            'names'=>'Rogelio',
            'lastname1'=>'Gamez',
            'lastname2'=>'',
            'email'=>'rogelio@logistic.com',
            'role'=>'administrador_de_sistema',
            'password'=>bcrypt('s0p0rt3'),
            'change_password'=>true
        ]);

        $permisos = Permission::all();
        foreach ($permisos as $permiso) {
        	//asigna permiso a usuario
            $user->givePermissionTo($permiso->name);
            //$rol->givePermissionTo($permission);
     	}

     	//asigna rol a usuario
        $user->assignRole('administrador_de_sistema');


        $user = User::create([
            'names'=>'Edgar',
            'lastname1'=>'Mendoza',
            'lastname2'=>'',
            'email'=>'edgar@logistic.com',
            'role'=>'administrador_de_sistema',
            'password'=>bcrypt('s0p0rt3'),
            'change_password'=>true
        ]);       

        $permisos = Permission::all();
        foreach ($permisos as $permiso) {
        	//asigna permiso a usuario
            $user->givePermissionTo($permiso->name);
            //$rol->givePermissionTo($permission);
     	}

     	//asigna rol a usuario
        $user->assignRole('administrador_de_sistema');
    }
}
