<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\instituciones;
use App\Models\programaciones;

class ProgramacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();

        /* $progra = DB::table('programaciones')
            ->join('instituciones', 'programaciones.prog_inst_id', '=', 'instituciones.id')
            ->select('programaciones.*', 'instituciones.inst_nombre', 'instituciones.inst_tipo')
            ->get(); */

        $progra = DB::select("select prog.*, insti.inst_nombre as institu,insti.inst_estado, esta.inst_nombre as estacion,esta.inst_estado as esta_estado from programaciones as prog,
        ( select * from instituciones where inst_tipo = '1') as insti,
        (select * from instituciones where inst_tipo = '2') as esta where prog.prog_inst_id = insti.id and prog.prog_inst_id_es = esta.id ");


        $roles = Role::all();
        //$progra = programaciones::all()->institucion;
        return response()->json([
            'roles' => $roles,
            'permisosuser' => $permisosuser,
            'progra' => $progra
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
        $progra = programaciones::create($request->post());
        //$progra = $request->post();
        return response()->json([
            'mensaje' => 'Se inserto la programación',
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
    public function edit($id)
    {
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();

        $insti = instituciones::where("inst_tipo", "=", "1")->where("inst_estado", "=", "A")->get();
        $estacion = instituciones::where("inst_tipo", "=", "2")->where("inst_estado", "=", "A")->get();

        $progra = programaciones::where("id", "=", $id)->get();

        return response()->json([
            'permisos' => $permisosuser,
            'insti' => $insti,
            'estacion' => $estacion,
            'progra' => $progra,

        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, programaciones $progra)
    {
        $progra->prog_fecha = $request->prog_fecha;
        $progra->prog_tipo_comb = $request->prog_tipo_comb;
        $progra->prog_lts = $request->prog_lts;
        $progra->prog_condicion = $request->prog_condicion;
        $progra->prog_observacion = $request->prog_observacion;
        $progra->prog_inst_id = $request->prog_inst_id;
        $progra->prog_inst_id_es = $request->prog_inst_id_es;
        $mensaje = $progra->save();
        return response()->json([
            'mensaje' => 'Se actualizó la programación',
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
        $prog = programaciones::find($id);
        $prog->delete();
        return response()->json([
            'mensaje' => 'Se borro la programación',
        ], 200);
    }
}
