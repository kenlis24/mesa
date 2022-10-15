<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\programaciones;

use Spatie\Permission\Models\Role;

use App\Models\progr_flotas;

class ProgrFlotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($prog, $insti, $tipo)
    {
        $progflot = DB::select("select instituciones.id, flotas.id as flo_id, inst_nombre, 
                pers_cedula, pers_nombres, 
                pers_apellidos, mca_nombre, 
                mod_nombre, vehi_placa,
                conp_lts 
            from instituciones, 
                trabajadores, 
                flotas, 
                personas,
                vehiculos, 
                modelo_vehi, 
                marca_vehi,
                conf_prog,
                programaciones
            where instituciones.id = '$insti' /* AQUI VA LA INSTITUCION PARA BUSCAR LOS DATOS DE LA FLOTA */
                and   inst_estado = 'A'
                and   prog_inst_id = instituciones.id
                and   programaciones.id = '$prog' /* ESTA ES LA PROGRAMACION A LA CUAL SE LE VA A AGREGAR LA FLOTA */
                and   prog_tipo_vehi = '$tipo'  /* AQUI VA EL TIPO DE VEHICULO A PROGRAMAR */
                and   trab_inst_id = instituciones.id
                and   trab_estado = 'A'
                and   personas.id = trab_pers_id
                and   pers_estado = 'A'
                and   flot_trab_id = trabajadores.id
                and   flot_estado = 'A'
                and  (programaciones.id, flotas.id)
                not in (select pflo_prog_id, pflo_flot_id
                        from progr_flotas
                        where pflo_prog_id = '$prog' and pflo_condicion = 'A')
                and   vehiculos.id = flot_vehi_id
                and   vehi_estado = 'A'
                and   vehi_tipo_vehi = prog_tipo_vehi 
                and   vehi_mod_id = modelo_vehi.id
                and   mod_mca_id = marca_vehi.id
                and   conp_tipo_vehi = vehi_tipo_vehi 
                order by instituciones.id, pers_cedula, vehi_placa");

        $progflotactiva = DB::select("select instituciones.id,flotas.id as flo_id, pflo_flot_id, inst_nombre, 
                    pers_cedula, pers_nombres, 
                    pers_apellidos, mca_nombre, 
                    mod_nombre, vehi_placa,
                    pflo_litros_paga,pflo_litros_desp,
                    conp_lts 
                from instituciones, 
                    trabajadores, 
                    flotas, 
                    personas,
                    vehiculos, 
                    modelo_vehi, 
                    marca_vehi,
                    conf_prog,
                    programaciones,
                    progr_flotas
                where instituciones.id = '$insti' /* AQUI VA LA INSTITUCION PARA BUSCAR LOS DATOS DE LA FLOTA */
                and   inst_estado = 'A'
                and   prog_inst_id = instituciones.id
                and   programaciones.id = '$prog' /* ESTA ES LA PROGRAMACION A LA CUAL SE LE VA A AGREGAR LA FLOTA */
                and   prog_tipo_vehi = '$tipo'  /* AQUI VA EL TIPO DE VEHICULO A PROGRAMAR */
                and   trab_inst_id = instituciones.id
                and   trab_estado = 'A'
                and   personas.id = trab_pers_id
                and   pers_estado = 'A'
                and   flot_trab_id = trabajadores.id
                and   flot_estado = 'A'
                and   pflo_condicion ='A'
                and   pflo_prog_id = programaciones.id
                and   pflo_flot_id = flotas.id
                and   vehiculos.id = flot_vehi_id
                and   vehi_estado = 'A'
                and   vehi_tipo_vehi = prog_tipo_vehi 
                and   vehi_mod_id = modelo_vehi.id
                and   mod_mca_id = marca_vehi.id
                and   conp_tipo_vehi = vehi_tipo_vehi 
                order by instituciones.id, pers_cedula, vehi_placa");
        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();

        return response()->json([
            'progflot' => $progflot,
            'progflotactiva' => $progflotactiva,
            'permisosuser' => $permisosuser
        ], 200);
    }

    public function reporte(Request $request)
    {
        $fech = $request->post('fecha');
        $sql = "select instituciones.id,flotas.id as flo_id, pflo_flot_id, inst_nombre, 
        pers_cedula, CONCAT(pers_nombres,' ',pers_apellidos) as nombre, mca_nombre, 
        mod_nombre, vehi_placa, vehi_tag,
        conp_lts, prog_fecha
    from instituciones, 
        trabajadores, 
        flotas, 
        personas,
        vehiculos, 
        modelo_vehi, 
        marca_vehi,
        conf_prog,
        programaciones,
        progr_flotas
    where    inst_estado = 'A'    
    and   date_format(prog_fecha,'%d-%m-%Y') = '$fech'
    and   prog_inst_id = instituciones.id                
    and   trab_inst_id = instituciones.id
    and   trab_estado = 'A'
    and   personas.id = trab_pers_id
    and   pers_estado = 'A'
    and   flot_trab_id = trabajadores.id
    and   flot_estado = 'A'
    and   pflo_condicion ='A'
    and   pflo_prog_id = programaciones.id
    and   pflo_flot_id = flotas.id
    and   vehiculos.id = flot_vehi_id
    and   vehi_estado = 'A'
    and   vehi_tipo_vehi = prog_tipo_vehi 
    and   vehi_mod_id = modelo_vehi.id
    and   mod_mca_id = marca_vehi.id
    and   conp_tipo_vehi = vehi_tipo_vehi 
    order by instituciones.id, pers_cedula, vehi_placa";
        $progflotrep = DB::select($sql);

        return response()->json([
            'progflotrep' => $progflotrep,
        ], 200);
    }

    public function reporteParam()
    {
        $progflotrepa = DB::select("select distinct inst_nombre, date_format(prog_fecha, '%d-%m-%Y') fecha
        from instituciones, 
            programaciones
        where    inst_estado = 'A'
        and   inst_tipo = 2
        and   prog_inst_id_es = instituciones.id   
        and   prog_estado = 'A'
        and   prog_inst_id_es != 1
        order by instituciones.id");

        $user = User::find(auth()->id());
        $permisosuser = $user->getPermissionsViaRoles();

        return response()->json([
            'progflotrepa' => $progflotrepa,
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

        $prog_id = $request->post('prog');
        $datos = $request->post('datos');
        $total = 0;
        $men = "";
        $progra = programaciones::where("id", "=", $prog_id)->get();
        if ($request->post('despa') == 'no') {
            foreach ($datos as $dat) {
                $total += $dat['conp_lts'];
            }
            if ($total <= $progra[0]->prog_lts) {
                foreach ($datos as $dat) {
                    $prog_flot_tot = 0;
                    $prog_flot_tot = progr_flotas::where("pflo_prog_id", "=", $prog_id)
                        ->where("pflo_flot_id", "=", $dat['flo_id'])->get()->count();
                    if ($prog_flot_tot == 1) {
                        $prog_flot = progr_flotas::where("pflo_prog_id", "=", $prog_id)
                            ->where("pflo_flot_id", "=", $dat['flo_id'])->get();
                        $upd = progr_flotas::find($prog_flot[0]->id);
                        $upd->pflo_condicion = 'C';
                        $upd->save();
                    } else {
                        $fila = array(
                            'pflo_litros' => $dat['conp_lts'],
                            'pflo_condicion' => 'C',
                            'pflo_litros_paga' => '0',
                            'pflo_litros_desp' => '0',
                            'pflo_observacion' => $dat['obs'],
                            'pflo_prog_id' => $prog_id,
                            'pflo_flot_id' => $dat['flo_id'],
                        );
                        progr_flotas::create($fila);
                    }
                    $men = "Se inserto la flota";
                }
                DB::table('progr_flotas')
                    ->where('pflo_prog_id', $prog_id)
                    ->where('pflo_condicion', 'A')
                    ->update(['pflo_condicion' => 'I']);

                DB::table('progr_flotas')
                    ->where('pflo_prog_id', $prog_id)
                    ->where('pflo_condicion', 'C')
                    ->update(['pflo_condicion' => 'A']);

                $programa = programaciones::find($prog_id);
                $programa->prog_condicion = '2';
                $programa->save();

                $men = "Se actualizo la flota a la programación";
                $codigo = "200";
            } else {
                $men = "Los litros programados no puede ser menor al total de la flota";
                $codigo = "422";
            }
        } else {
            foreach ($datos as $dat) {
                $prog_flot = progr_flotas::where("pflo_prog_id", "=", $prog_id)
                    ->where("pflo_flot_id", "=", $dat['flo_id'])->get();
                $upd = progr_flotas::find($prog_flot[0]->id);
                $upd->pflo_litros_paga = $dat['litros_paga'];
                $upd->pflo_litros_desp = $dat['litros_desp'];
                $upd->pflo_observacion = $dat['obs'];
                $upd->save();
                $men = "Se actualizo el despacho de litros a la flota";
                $codigo = "200";
            }
        }
        return response()->json([
            'mensaje' => $men,
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
