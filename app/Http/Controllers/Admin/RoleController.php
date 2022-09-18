<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\conf_rol_inst;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();


        $roles = Role::all();
        return response()->json([
            'roles' => $roles,
            'permisosuser' => $permisosuser
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //     
        $Data = array('name' => $request->post('name'));
        $roles = Role::create($Data);
        if ($request->post('permitir')) {
            $Data = array('rins_nombre' => $request->post('name'), 'rins_estado' => 'A');
            conf_rol_inst::create($Data);
        }
        return response()->json([
            'roles' => $roles,
            'mensaje' => 'Se registro el rol'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        $permisosrol = $role->permissions;


        if (conf_rol_inst::where("rins_nombre", "=", $role->name)->where("rins_estado", "=", 'A')->get()->count() >= 1) {
            $rol_insti = true;
        } else {
            $rol_insti = false;
        }


        return response()->json([
            'rol' => $role,
            'permisosRol' => $permisosrol,
            'permisos' => $permisos,
            'rol_insti' => $rol_insti
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rol_inst_tot = conf_rol_inst::where("rins_nombre", "=", $request->post('role'))->get()->count();
        if ($rol_inst_tot >= 1) {
            $rol_inst_id = conf_rol_inst::where("rins_nombre", "=", $request->post('role'))->get();
            $rol_inst = conf_rol_inst::find($rol_inst_id[0]->id);
            if ($request->post('permitir')) {
                $rol_inst->rins_estado = 'A';
            } else {
                $rol_inst->rins_estado = 'I';
            }
            $rol_inst->save();
        } else {
            $Data = array('rins_nombre' => $request->post('role'), 'rins_estado' => 'A');
            conf_rol_inst::create($Data);
        }
        $permisos = $request->post('permisos');
        $role->syncPermissions($permisos);

        return response()->json([
            'mensaje' => 'Se actualizó los permisos ',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'mensaje' => 'Se borro el Rol',
        ], 200);
    }
}
