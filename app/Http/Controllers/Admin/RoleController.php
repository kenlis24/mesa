<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

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
        $roles = Role::create($request->post());
        return response()->json([
            'roles' => $roles,
        ]);
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

        return response()->json([
            'rol' => $role,
            'permisosRol' => $permisosrol,
            'permisos' => $permisos
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
        $permisos = $request->all();
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
