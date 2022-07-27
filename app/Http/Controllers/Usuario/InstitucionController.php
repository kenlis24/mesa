<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\instituciones;

use Illuminate\Support\Facades\Validator;
use App\Models\area_servicios;
use App\Models\parroquias;

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
        $validator = Validator::make(
            $request->all(),
            [
                'inst_rif' => 'unique:instituciones',
            ]
        );
        if ($validator->fails()) {
            $mensaje = 'El rif ya está registrado';
            $codigo = 422;
        } else {
            $insti = instituciones::create($request->post());
            $mensaje = 'Se Registró la institución';
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

        $parroq = parroquias::where("par_estado", "=", "A")->get();
        $areaser = area_servicios::where("aser_estado", "=", "A")->get();

        $insti = instituciones::where("id", "=", $id)->get();


        return response()->json([
            'permisos' => $permisosuser,
            'insti' => $insti,
            'parroq' => $parroq,
            'areaser' => $areaser,

        ], 200);
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
        } else {
            $insti = instituciones::find($id);
            $insti->inst_rif = $request->inst_rif;
            $insti->inst_nombre = $request->inst_nombre;
            $insti->inst_direccion = $request->inst_direccion;
            $insti->inst_telefono = $request->inst_telefono;
            $insti->inst_correo = $request->inst_correo;
            $insti->inst_dependencia = $request->inst_dependencia;
            $insti->inst_sector = $request->inst_sector;
            $insti->inst_estado = $request->inst_estado;
            $insti->inst_observacion = $request->inst_observacion;
            $insti->inst_par_id = $request->inst_par_id;
            $insti->inst_aser_id = $request->inst_aser_id;
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
        /* $insti = instituciones::find($id);
        $insti->delete();
        return response()->json([
            'mensaje' => 'Se borro la institución',
        ], 200); */
    }
}
