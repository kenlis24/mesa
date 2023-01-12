<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\personas;
use App\Models\vehiculos;
use App\Models\pers_com;
use App\Models\comunidades;
use App\Models\agrupaciones;
use App\Models\parroquias;
use App\Models\municipios;
use App\Models\cargos;

class PersonaController extends Controller
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
        $personas = personas::all();
        $comunidades = comunidades::where("com_estado", "=", "A")->get();
        $agrupaciones = agrupaciones::where("agr_estado", "=", "A")->get();
        $parroquias = parroquias::where("par_estado", "=", "A")->get();
        $municipios = municipios::where("mun_estado", "=", "A")->get();
        $cargos = cargos::where("car_estado", "=", "A")->get();


        return response()->json([
            'personas' => $personas,
            'permisosuser' => $permisosuser,
            'comunidades' => $comunidades,
            'agrupaciones' => $agrupaciones,
            'parroquias' => $parroquias,
            'municipios' => $municipios,
            'cargos' => $cargos,
        ], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultar($id)
    {
        //$fech = $request->post('fecha');
        $sql = "SELECT pers.id, pers.pers_cedula, pers.pers_nombres, pers.pers_apellidos,
        pers.pers_fec_nac, pers.pers_sexo,pers.pers_telf_cel, pers.pers_correo,
        pers.pers_observacion, pers_coms.id as id_pers_coms, pers_coms.pcom_telf_res,
        pers_coms.pcom_calle, pers_coms.pcom_casa, comunidades.id as id_comunidad,
        comunidades.com_nombre,cargos.id as id_cargo, cargos.car_nombre,
        agrupaciones.id as id_agrup, agrupaciones.agr_nombre,parroquias.id as id_parroq,
        parroquias.par_nombre,municipios.id as id_munic, municipios.mun_nombre
        FROM personas pers,
        pers_coms,
        cargos,
        comunidades,
        agrupaciones,
        parroquias,
        municipios
        WHERE 
        pers.pers_estado = 'A'
        AND pers.id = pers_coms.pcom_pers_id
        AND pers_coms.pcom_car_id = cargos.id
        AND cargos.car_estado = 'A'
        AND pers_coms.pcom_com_id = comunidades.id
        AND comunidades.com_estado = 'A'
        AND agrupaciones.id = comunidades.com_agr_id
        AND agrupaciones.agr_estado = 'A'
        AND parroquias.id = agrupaciones.agr_par_id
        AND parroquias.par_estado ='A'
        AND municipios.id = parroquias.par_mun_id
        AND municipios.mun_estado='A'
        AND pers.id='$id'";
        $persona = DB::select($sql);
        $comunidades = comunidades::where("com_estado", "=", "A")->get();
        $agrupaciones = agrupaciones::where("agr_estado", "=", "A")->get();
        $parroquias = parroquias::where("par_estado", "=", "A")->get();
        $municipios = municipios::where("mun_estado", "=", "A")->get();
        $cargos = cargos::where("car_estado", "=", "A")->get();


        return response()->json([
            'persona' => $persona,
            'comunidades' => $comunidades,
            'agrupaciones' => $agrupaciones,
            'parroquias' => $parroquias,
            'municipios' => $municipios,
            'cargos' => $cargos,
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
                'pers_cedula' => 'unique:personas',
            ]
        );
        if ($validator->fails()) {
            $mensaje = 'La cédula ya está registrada';
            $codigo = 422;
        } else {
            $perso = array(
                'pers_cedula' => $request->post("pers_cedula"),
                'pers_nombres' => $request->post("nombres"),
                'pers_apellidos' => $request->post("apellidos"),
                'pers_fec_nac' => $request->post("fecha_nac"),
                'pers_sexo' => $request->post("sexo"),
                'pers_telf_cel' => $request->post("telfcel"),
                'pers_correo' => $request->post("correo"),
                'pers_estado' => 'A',
                'pers_observacion' => $request->post("observ"),
            );
            $persoid = personas::create($perso);
            $fecha_act = Carbon::now();
            $fecha_act = $fecha_act->toDateTimeString();
            $pers_coms = array(
                'pcom_fecha_act' => $fecha_act,
                'pcom_telf_res' => $request->post("telfcasa"),
                'pcom_calle' => $request->post("calle"),
                'pcom_casa' => $request->post("direccion"),
                'pcom_fecha_inac' => $fecha_act,
                'pcom_estado' => 'A',
                'pcom_com_id' => $request->post("comunidad"),
                'pcom_pers_id' => $persoid->id,
                'pcom_car_id' => $request->post("cargo"),
            );
            pers_com::create($pers_coms);
            $mensaje = 'Se Registró los datos';
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
            $insti = personas::find($id);
            $insti->pers_estado = $acti == 'A' ? 'I' : 'A';
            $insti->save();
            $mensaje = 'Se cambió el estado';
            $codigo = 200;
        } else {
            $paso = false;
            $validator = false;
            $validator = Validator::make(
                $request->all(),
                [
                    'pers_cedula' => 'unique:personas',
                ]
            );
            if ($validator->fails()) {
                $mensaje = 'La cedula ya existe';
                $codigo = 422;
                $paso = true;
            }
            if (!($request->cambio == 'si' && $paso)) {
                //para actualizar tabla personas
                $perso = personas::find($id);
                $perso->pers_cedula  = $request->pers_cedula;
                $perso->pers_nombres = $request->nombres;
                $perso->pers_apellidos = $request->apellidos;
                $perso->pers_fec_nac = $request->fecha_nac;
                $perso->pers_sexo = $request->sexo;
                $perso->pers_telf_cel = $request->telfcel;
                $perso->pers_correo = $request->correo;
                $perso->pers_observacion = $request->observ;
                $perso->save();
                //para actualizar tabla pers_coms
                $fecha_act = Carbon::now();
                $fecha_act = $fecha_act->toDateTimeString();
                $pers_com = pers_com::find($request->id_pers_coms);
                $pers_com->pcom_fecha_act  = $fecha_act;
                $pers_com->pcom_telf_res  = $request->telfcasa;
                $pers_com->pcom_calle = $request->calle;
                $pers_com->pcom_casa = $request->direccion;
                $pers_com->pcom_com_id = $request->comunidad;
                $pers_com->pcom_car_id = $request->cargo;
                $pers_com->save();
                $mensaje = 'Se actualizó la informacion de la persona';
                $codigo = 200;
            }
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
