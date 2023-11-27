<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::select('id', 'name', 'display_name', 'description')->get();

        return response()->json($roles);
    }

    public function edit($id){
        $rol = Role::where('id', $id)->select('id', 'display_name as name', 'description')->first();
        return response()->json($rol);
    }

    public function store(Request $request){
        try{
            \DB::beginTransaction();
            $rol = new Role();
            $rol->name = $request->name;
            $rol->display_name = $request->display_name;
            $rol->description = $request->description;
            $rol->guard_name = 'api';
            $rol->save();

            \DB::commit();
            
            return response()->json([
                'ok' => true,
                'mensaje' => 'El rol '.$rol->name.' se registro correctamente.'
            ]);
            
        }catch(\Exception $e){
            \DB::rollback();
            //dd($e);
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage()]);
        }
    }

    public function update($id, Request $request){
        /* verificar que el rol no este asignado a ningun usuario */
        try{
            \DB::beginTransaction();
            $rol = Role::where('id', $id)->first();
            $rol->fill($request->all());
            $rol->save();

            \DB::commit();
            
            return response()->json([
                'ok' => true,
                'mensaje' => 'El rol '.$rol->name.' se actualizo correctamente.'
            ]);
            
        }catch(\Exception $e){
            \DB::rollback();
            //dd($e);
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage()]);
        }
    }

    public function delete($id){
        try{
            \DB::beginTransaction();
            $role = Role::find($id);

            /**
             * verifica si existen usuarios que tengan asignado el rol
             * si existen usuarios regresa un error
             */
            $users = $this->verify($id);

            if($users > 0){
                return response()->json([
                    'error' => 'No es posible eliminar el registro debido a que uno o mas usuarios 
                                tienen el rol '.$role->display_name.' asignado'
                ]);
            }

            $role->delete();

            \DB::commit();

            return response()->json([
                'message'=>"Rol ".$role->display_name." se elimino con exito."
            ]);
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['error'=>'ERROR ('.$e->getCode().'): '.$e->getMessage()]);
        }
    }

    public function verify($id){
        $rol = Role::where('id', $id)->select('name')->first();
        
        $user = User::where('role', $rol->name)->where('active', 1)->get();

        return count($user);
    }
}
