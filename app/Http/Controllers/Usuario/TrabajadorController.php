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
use App\Models\flotas;
use App\Models\conf_rol_inst;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->id());
        $roles = $user->getRoleNames()->toArray();
        $soloinsti = false;
        $roles_insti = conf_rol_inst::where("rins_estado", "=", 'A')->pluck('rins_nombre');
        $sql = " AND inst.id in(select usui_inst_id from usu_insts where usui_estado ='A' and usui_usu_id =" . auth()->id() . ")";
        foreach ($roles_insti as $valor) {
            if (in_array($valor, $roles)) {
                $sql = ' ';
                $soloinsti = true;
            }
        }
        $sql2 = "SELECT trab.*,pers.id as pers_id,pers.pers_cedula,pers.pers_nombres,pers.pers_apellidos,inst.inst_nombre FROM trabajadores as trab,personas as pers,instituciones as inst
                WHERE 
                trab.id != '1'
                AND trab.trab_inst_id=inst.id
                $sql
                AND trab.trab_pers_id=pers.id
                ORDER by id ASC;";
        $trabajadores = DB::select($sql2);
        $sql3 = "SELECT trab.*,pers.pers_cedula,pers.pers_nombres,pers.pers_apellidos,inst.inst_nombre FROM trabajadores as trab,personas as pers,instituciones as inst
                WHERE 
                trab.id != '1'
                AND trab.trab_inst_id=inst.id
                AND trab.trab_pers_id=pers.id
                $sql
                AND trab.id NOT IN  (SELECT flot_trab_id from flotas)
                ORDER by id ASC;";
        $transinflota = DB::select($sql3);
        if ($soloinsti)
            $instituciones = instituciones::where("inst_estado", "=", 'A')->where("id", "!=", "1")->get();
        else {
            $sql4 = "SELECT * FROM instituciones as inst
                    WHERE 
                    inst.id != '1' 
                    $sql
                    ";
            $instituciones = DB::select($sql4);
        }
        $sql5 = "SELECT pers.*,vehi.id as vehi_id ,vehi_mod_id FROM personas as pers,vehiculos as vehi 
                WHERE
                vehi_pers_id = pers.id
                AND pers.id != '1'
                AND pers.pers_estado = 'A'
                AND vehi.vehi_estado = 'A'
                ORDER BY pers_cedula ASC;";
        $personas = DB::select($sql5);
        //$personas = personas::where("pers_estado", "=", 'A')->where("id", "!=", "1")->get();

        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();


        return response()->json([
            'trabajadores' => $trabajadores,
            'transinflota' => $transinflota,
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
            $flota = array(
                'flot_fecha_act' => $fecha_act,
                'flot_estado' => 'A',
                'flot_trab_id' => $trabaid->id,
                'flot_vehi_id' => $request->post("id_car"),
            );
            $flotaid = flotas::create($flota);
            $mensaje = 'Se Registró el trabajador y su flota';
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trabasinflota(Request $request)
    {
        $fecha_act = Carbon::now();
        $fecha_act = $fecha_act->toDateTimeString();
        $pers = $request->post("pers_id");
        $sql = "SELECT vehi.id as vehi_id FROM personas as pers,vehiculos as vehi 
                WHERE
                vehi_pers_id = pers.id
                AND pers.id = '$pers'
                AND pers.id != '1'
                AND pers.pers_estado = 'A'
                AND vehi.vehi_estado = 'A'
                ORDER BY pers_cedula ASC;";
        $vehi = DB::select($sql);
        $num = count($vehi);
        if ($num != 0) {
            $flota = array(
                'flot_fecha_act' => $fecha_act,
                'flot_estado' => 'A',
                'flot_trab_id' => $request->post("id"),
                'flot_vehi_id' => $vehi[0]->vehi_id,
            );
            $flotaid = flotas::create($flota);
            $codigo = 200;
            $mensaje = 'Se le creo la flota';
        } else {
            $codigo = 400;
            $mensaje = 'La persona no tiene un carro asignado para crearle la flota';
        }

        return response()->json([
            'mensaje' => $mensaje,
        ], $codigo);
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
