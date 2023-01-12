<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\modelo_vehi;
use App\Models\User;
use App\Models\personas;
use App\Models\vehiculos;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = "SELECT vehiculos.id,vehi_placa,vehi_tag,if (vehi_tipo_vehi=1,'Automovil','Motocicleta') as vehi_tipo_vehi,
                mod_nombre,vehi_estado 
                from vehiculos,modelo_vehi,marca_vehi
                where
                vehi_mod_id = modelo_vehi.id
                and modelo_vehi.mod_estado = 'A'
                and mod_mca_id = marca_vehi.id
                and marca_vehi.mca_Estado = 'A';";
        $vehiculos = DB::select($sql);

        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();


        return response()->json([
            'vehiculos' => $vehiculos,
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
        $validator = Validator::make(
            $request->all(),
            [
                'vehi_placa' => 'unique:vehiculos',
                'vehi_tag' => 'unique:vehiculos',
            ]
        );
        if ($validator->fails()) {
            $mensaje = 'La placa o tag ya fue registrado';
            $codigo = 422;
        } else {
            $vehi = array(
                'vehi_placa' => $request->post("vehi_placa"),
                'vehi_tag' => $request->post("vehi_tag"),
                'vehi_tipo_vehi' => $request->post("vehi_tipo_vehi"),
                'vehi_tipo_comb' => $request->post("vehi_tipo_comb"),
                'vehi_capacidad_Lts' => $request->post("vehi_capacidad_Lts"),
                'vehi_estado' => $request->post("vehi_estado"),
                'vehi_observacion' => $request->post("vehi_observacion"),
                'vehi_pers_id' => $request->post("vehi_pers_id"),
                'vehi_mod_id' => $request->post("vehi_mod_id"),
            );
            $vehiid = vehiculos::create($vehi);
            $mensaje = 'Se Registró el vehiculo';
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
     * para obtener datos de personas y modelo vehiculo.
     *
     * @return \Illuminate\Http\Response
     */
    public function persoymodel()
    {
        //$modelos = modelo_vehi::all();
        $modelos = modelo_vehi::where("mod_nombre", "!=", "Por Actualizar")->where("mod_estado", "=", "A")->get();
        $personas = personas::where("pers_estado", "=", "A")->get();
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();
        //$personas = personas::all();

        return response()->json([
            'modelos' => $modelos,
            'personas' => $personas,
            'permisosuser' => $permisosuser,
        ], 200);
    }

    public function consulxpers($id)
    {
        //$fech = $request->post('fecha');
        $sql = "SELECT vehi.id, pers.id as pers_id, pers_cedula, pers_nombres, pers_apellidos,
                vehi_placa, vehi_tag,if (vehi_tipo_vehi=1,'Automovil','Motocicleta') as vehi_tipo_vehi,
                mca_nombre, mod_nombre,vehi_capacidad_lts,vehi_pers_id 
                from instituciones inst, trabajadores trab, flotas, personas pers,
                vehiculos vehi, marca_vehi mcav, modelo_vehi modv
                where
                pers.id='$id'
                and   inst_estado = 'A'
                and   trab_inst_id = inst.id
                and   trab_estado = 'A'
                and   flot_trab_id = trab.id
                and   flot_estado = 'A'
                and   pers.id = trab_pers_id
                and   pers_estado = 'A'
                and   vehi_pers_id = pers.id
                and   vehi_estado = 'A'
                and   modv.id = vehi_mod_id
                and   mod_mca_id = mcav.id
                order by 1,4,7;";
        $persona = DB::select($sql);
        $number = count($persona);
        if ($number < 1) {
            $sql = "SELECT  pers.id as pers_id, pers_cedula, pers_nombres, pers_apellidos   
                from personas pers
                where
                pers.id='$id'
                order by 1;";
            $persona = DB::select($sql);
            $completar = "";
        } else {
            $vehi = $persona[0]->id;
            $completar = " and vehiculos.id NOT in ($vehi) ";
        }
        $sql2 = "SELECT vehiculos.id,vehi_placa,vehi_tag,if (vehi_tipo_vehi=1,'Automovil','Motocicleta') as vehi_tipo_vehi,
                mca_nombre,mod_nombre,vehi_pers_id 
                from vehiculos,modelo_vehi,marca_vehi
                where
                vehi_estado = 'A'
                $completar
                and vehi_mod_id = modelo_vehi.id
                and modelo_vehi.mod_estado = 'A'
                and mod_mca_id = marca_vehi.id
                and marca_vehi.mca_Estado = 'A';";
        $vehiculos = DB::select($sql2);
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();
        return response()->json([
            'persona' => $persona,
            'vehi' => $vehiculos,
            'permisosuser' => $permisosuser,
            'number' => $number
        ], 200);
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

        $sql = "SELECT vehiculos.id as id,vehi_placa,vehi_tag, vehi_tipo_vehi,
                vehi_mod_id,vehi_estado,vehi_capacidad_Lts,vehi_tipo_comb
                from vehiculos,modelo_vehi,marca_vehi
                where
                vehiculos.id='$id'
                and vehi_mod_id = modelo_vehi.id
                and modelo_vehi.mod_estado = 'A'
                and mod_mca_id = marca_vehi.id
                and marca_vehi.mca_Estado = 'A';";
        $vehiculo = DB::select($sql);
        $modelo = modelo_vehi::where("mod_estado", "=", "A")->get();

        return response()->json([
            'permisosuser' => $permisosuser,
            'vehiculo' => $vehiculo,
            'modelo' => $modelo,

        ], 200);
    }
    public function vehiupdate(Request $request, $id)
    {
        $auto = $request->all();
        $vehi = vehiculos::find($id);
        if (empty($auto['vehi_observacion']))
            $vehi->vehi_observacion = '';
        else
            $vehi->vehi_observacion = $auto['vehi_observacion'];
        $vehi->vehi_placa = $auto['vehi_placa'];
        $vehi->vehi_tag = $auto['vehi_tag'];
        $vehi->vehi_tipo_vehi = $auto['vehi_tipo_vehi'];
        $vehi->vehi_tipo_comb = $auto['vehi_tipo_comb'];
        $vehi->vehi_capacidad_Lts = $auto['vehi_capacidad_Lts'];

        $vehi->vehi_mod_id = $auto['vehi_mod_id'];
        $vehi->save();

        return response()->json([
            'mensaje' => 'Se actualizo el registro',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $unico)
    {
        $auto = $request->all();
        $busq = vehiculos::where('vehi_pers_id', $id)->get();
        $vehi = vehiculos::find($auto[0]['id']);
        $vehi->vehi_pers_id = $id;
        $vehi->save();
        if ($unico != 0 && ($auto[0]['id'] != $busq[0]->id)) {
            $vehi = vehiculos::find($busq[0]->id);
            $vehi->vehi_pers_id = '1';
            $vehi->save();
        }
        return response()->json([
            'mensaje' => 'Se actualizó la asignación del carro',
        ], 200);
    }
    /**
     * desactiva el carro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vehiculodesac(Request $request, $id, $acti)
    {
        $vehi = vehiculos::find($id);
        $vehi->vehi_estado = $acti == 'A' ? 'I' : 'A';
        $vehi->save();

        return response()->json([
            'mensaje' => 'Se cambió el estado',
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
