<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\usu_inst;

class UsuInstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $datos = $request->post('datos');
        $id_usu = $request->post('id_usu');
        $men = '';
        foreach ($datos as $dat) {
            $asig_total = 0;
            $asig_total = usu_inst::where("usui_inst_id", "=", $dat['id'])
                ->where("usui_usu_id", "=", $dat['id_usu'])->get()->count();
            if ($asig_total == 1) {
                $asig_inst_usu = usu_inst::where("usui_inst_id", "=", $dat['id'])
                    ->where("usui_usu_id", "=", $dat['id_usu'])->get();
                $upd = usu_inst::find($asig_inst_usu[0]->id);
                $upd->usui_estado = 'C';
                $upd->save();
            } else {
                $fecha_act = Carbon::now();
                $fecha_act = $fecha_act->toDateTimeString();
                $fila = array(
                    'usui_fecha_act' => $fecha_act,
                    'usui_fecha_inac' => $fecha_act,
                    'usui_estado' => 'C',
                    'usui_observacion' => $dat['obs'],
                    'usui_inst_id' => $dat['id'],
                    'usui_usu_id' => $dat['id_usu'],
                );
                usu_inst::create($fila);
            }
            $men = "Se inserto la(s) Instituciones al usuario";
        }
        DB::table('usu_insts')
            ->where('usui_usu_id', $id_usu)
            ->where('usui_estado', 'A')
            ->update(['usui_estado' => 'I']);

        DB::table('usu_insts')
            ->where('usui_usu_id', $id_usu)
            ->where('usui_estado', 'C')
            ->update(['usui_estado' => 'A']);
        if ($men)
            $codigo = 200;
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
