<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\atencion_est_int;
use App\Models\conf_rol_inst;
use Carbon\Carbon;

class AtencionEstIntController extends Controller
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

        return response()->json([
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
        $id = auth()->id();
        $user = User::find($id);
        $roles = $user->getRoleNames()->toArray();
        $roles_insti = conf_rol_inst::where("rins_estado", "=", 'A')->pluck('rins_nombre');
        $sql = " and instituciones.id in(select usui_inst_id from usu_insts where usui_estado ='A' and usui_usu_id =" . auth()->id() . ")";
        foreach ($roles_insti as $valor) {
            if (in_array($valor, $roles))
                $sql = ' ';
        }
        $insti = DB::select("select * 
            from instituciones
            where instituciones.inst_tipo in ('1','2')
                $sql order by inst_nombre");
        $usuario = $id;
        $fecha = Carbon::now();
        $fecha_act = date("Y-m-d");
        $vehi = array(
            'atei_usu_id' => $usuario,
            'atei_usuins_id' => $insti[0]->id,
            'atei_usui_mod_id' => null,
            'atei_placa' => $request->post("atei_placa"),
            'atei_tipo_vehi' => $request->post("atei_tipo_vehi"),
            'atei_tipo_comb' => $request->post("atei_tipo_comb"),
            'atei_litros' => $request->post("atei_litros"),
            'atei_cedula' => $request->post("atei_cedula"),
            'atei_telefono' => $request->post("atei_telefono"),
            'atei_fecha' => $fecha,
            'atei_estado' => 'A',
        );
        $existe = atencion_est_int::where("atei_estado", "=", "A")
            ->where("atei_placa", "=", $request->post("atei_placa"))
            ->where(DB::raw("(DATE_FORMAT(atei_fecha,'%Y-%m-%d'))"), "=", $fecha_act)
            ->get();
        if (count($existe) > 0) {
            $id_inst = $existe[0]['atei_usuins_id'];
            $hora = $existe[0]['atei_fecha'];
            $sql2 = "SELECT inst_nombre FROM instituciones WHERE id = $id_inst";
            $estacion = DB::select($sql2);
            $mensaje =  "El vehiculo ya surtio hoy: " . $estacion[0]->inst_nombre . " " . $hora;
            $codigo = 422;
        } else {
            atencion_est_int::create($vehi);
            $mensaje =  "Se registro el Vehículo";
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
    public function lista(Request $request)
    {
        $placa = $request->post("atei_placa");
        $sql = "SELECT atei_placa,atei_fecha,inst.inst_nombre as estacion
        FROM atencion_est_ints join instituciones as inst 
        WHERE inst.id = atei_usuins_id AND atei_placa= '$placa'";
        $movi = DB::select($sql);
        if (count($movi) > 0) {
            $mensaje = "Placa encontrada";
            $codigo = 200;
        } else {
            $mensaje = "Placa no encontrada";
            $codigo = 422;
        }
        return response()->json([
            'datos' => $movi,
            'mensaje' => $mensaje,
        ], $codigo);
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
    public function update(Request $request, $id)
    {
        //
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
