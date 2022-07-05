<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\instituciones;

use Spatie\Permission\Models\Permission;


class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insti = instituciones::where("inst_tipo", "=", "1")->where("inst_estado", "=", "A")->get();
        $institodas = instituciones::all();
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();

        return response()->json([
            'insti' => $insti,
            'institodas' => $institodas,
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $acti = null)
    {
        if ($acti) {

            $insti = instituciones::find($id);
            $insti->inst_estado = $acti == 'A' ? 'I' : 'A';
            $insti->save();
        }
        return response()->json([
            'mensaje' => $acti != NULL ? 'Se cambió el estado' : 'Se actualizó la institucion',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insti = instituciones::find($id);
        $insti->delete();
        return response()->json([
            'mensaje' => 'Se borro la institución',
        ], 200);
    }
}
