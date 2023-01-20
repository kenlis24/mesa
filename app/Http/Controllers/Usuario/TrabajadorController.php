<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\trabajadores;
use App\Models\instituciones;
use App\Models\personas;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = "SELECT trab.*,pers.pers_cedula,pers.pers_nombres,pers.pers_apellidos,inst.inst_nombre FROM trabajadores as trab,personas as pers,instituciones as inst
                WHERE 
                trab.id != '1'
                AND trab.trab_inst_id=inst.id
                AND trab.trab_pers_id=pers.id
                ORDER by id ASC;";
        $trabajadores = DB::select($sql);
        $instituciones = instituciones::where("inst_estado", "=", 'A')->where("id", "!=", "1")->get();
        $personas = personas::where("pers_estado", "=", 'A')->where("id", "!=", "1")->get();

        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();


        return response()->json([
            'trabajadores' => $trabajadores,
            'permisosuser' => $permisosuser,
            'instituciones' => $instituciones,
            'personas' => $personas
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
        $validator = Validator::make(
            $request->all(),
            [
                'trab_pers_id' => 'unique:trabajadores',
            ]
        );
        if ($validator->fails()) {
            $mensaje = 'La persona ya se encuentra como trabajador';
            $codigo = 422;
        } else {
            $fecha_act = Carbon::now();
            $fecha_act = $fecha_act->toDateTimeString();
            $traba = array(
                'trab_tipo_trabajador' => $request->post("trab_tipo_trabajador"),
                'trab_fecha_act' => $fecha_act,
                'trab_estado' => $request->post("trab_estado"),
                'trab_observacion' => $request->post("trab_observacion"),
                'trab_inst_id' => $request->post("trab_inst_id"),
                'trab_pers_id' => $request->post("trab_pers_id"),
            );
            $trabaid = trabajadores::create($traba);
            $mensaje = 'Se Registró el trabajador';
            $codigo = 200;
        }
        return response()->json([
            'mensaje' => $mensaje,
        ], $codigo);
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

        $sql = "SELECT trab.*,pers.pers_cedula,pers.pers_nombres,pers.pers_apellidos,inst.inst_nombre FROM trabajadores as trab,personas as pers,instituciones as inst
                WHERE 
                trab.id != '1'
                AND trab.id = '$id'
                AND trab.trab_inst_id=inst.id
                AND trab.trab_pers_id=pers.id
                ORDER by id ASC;";
        $trabajador = DB::select($sql);
        $instituciones = instituciones::where("inst_estado", "=", 'A')->where("id", "!=", "1")->get();
        $personas = personas::where("pers_estado", "=", 'A')->where("id", "!=", "1")->get();

        return response()->json([
            'permisosuser' => $permisosuser,
            'trabajador' => $trabajador,
            'instituciones' => $instituciones,
            'personas' => $personas,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $acti)
    {
        $trab = trabajadores::find($id);
        $trab->trab_estado = $acti == 'A' ? 'I' : 'A';
        $trab->save();

        return response()->json([
            'mensaje' => 'Se cambió el estado',
        ], 200);
    }
    public function trabupdate(Request $request, $id)
    {
        $trab = trabajadores::find($id);
        $trab->trab_tipo_trabajador = $request->post("trab_tipo_trabajador");
        $trab->trab_observacion = $request->post("trab_observacion");
        $trab->trab_inst_id = $request->post("trab_inst_id");
        $trab->save();

        return response()->json([
            'mensaje' => 'Se actualizó el trabajador',
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
        //
    }
}
