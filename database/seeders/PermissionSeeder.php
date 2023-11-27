<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('permissions')->delete();


        \DB::table('permissions')->insert([
            'name'          => 'admin_menu',
            'display_name'  => 'Menú Admin',
            'description'   => 'Permite ver el menu de gestión de permisos, roles y usuarios.',
            'guard_name'	=> 'api'
        ]);

        \DB::table('permissions')->insert([
            'name'          => 'admin_permissions',
            'display_name'  => 'Listado de permisos',
            'description'   => 'Permite ver el listado de los permisos registrados en el sistema.',
            'guard_name'	=> 'api'
        ]);


        \DB::table('permissions')->insert([
            'name'          => 'admin_roles',
            'display_name'  => 'Listado Roles',
            'description'   => 'Permite ver el listado de roles que se encuentran en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_permissions_assign',
            'display_name'  => 'Asignar permisos a rol',
            'description'   => 'Permite asignar permisos a un rol.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_roles_create',
            'display_name'  => 'Registro de roles',
            'description'   => 'Permite registrar un nuevo rol en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_roles_update',
            'display_name'  => 'Edición de roles',
            'description'   => 'Permite actualizar un rol en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_roles_delete',
            'display_name'  => 'Eliminar roles',
            'description'   => 'Permite eliminar un rol en el sistema.',
            'guard_name'	=> 'api'
        ]);

        \DB::table('permissions')->insert([
            'name'          => 'admin_users',
            'display_name'  => 'Listado Empleados',
            'description'   => 'Permite ver el listado de empleados que se encuentran en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_users_create',
            'display_name'  => 'Registro de empleados',
            'description'   => 'Permite registrar un nuevo empleado en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_users_update',
            'display_name'  => 'Edición de empleados',
            'description'   => 'Permite actualizar un empleado en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_users_delete',
            'display_name'  => 'Eliminar empleados',
            'description'   => 'Permite eliminar un empleado en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_users_change_password',
            'display_name'  => 'Actualizar contraseña de empleados',
            'description'   => 'Permite actualizar la contraseña de un empleado en el sistema.',
            'guard_name'	=> 'api'
        ]);
        \DB::table('permissions')->insert([
            'name'          => 'admin_users_role_assign',
            'display_name'  => 'Asignar rol a usuario',
            'description'   => 'Permite asignar un rol a un usuario desde el formulario.',
            'guard_name'	=> 'api'
        ]);

    }
}
