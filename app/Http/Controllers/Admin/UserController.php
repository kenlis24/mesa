<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::all();
        $usuarios = User::all();
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();


        return response()->json([
            'usuarios' => $usuarios,
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
    public function edit(User $user)
    {
        $roles = Role::all();
        $roleuser = $user->getRoleNames();

        return response()->json([
            'roles' => $roles,
            'user' => $user,
            'permisos' => $roleuser
        ], 200);
        //return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $roles = $request->all();
        $mensaje = $user->syncRoles($roles);

        return response()->json([
            'mensaje' => 'Se actualizó los roles',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $roleuser = $user->getRoleNames();
        $mensaje = $user->syncRoles('');
        $user->delete();
        return response()->json([
            'mensaje' => 'Se borro el usuario',
        ], 200);
    }


    protected function getRoles()
    {
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();
        return response()->json([
            'permisosuser' => $permisosuser
        ], 200);
    }
}
