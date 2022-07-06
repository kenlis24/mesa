<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instituciones extends Model
{
    use HasFactory;

    protected $fillable = ['inst_rif', 'inst_nombre', 'inst_tipo', 'inst_direccion', 'inst_telefono', 'inst_correo', 'inst_dependencia', 'inst_sector', 'inst_estado', 'inst_observacion', 'inst_par_id', 'inst_aser_id'];


    public function parroquia()
    {
        return $this->belongsTo(parroquias::class,  'inst_par_id');
    }

    public function area_serevicio()
    {
        return $this->belongsTo(area_serevicios::class,  'inst_aser_id');
    }

    public function atenciones()
    {
        return $this->hasMany(atenciones::class, 'aten_inst_id');
    }

    public function usu_insts()
    {
        return $this->hasMany(usu_insts::class, 'usui_inst_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(asignaciones::class, 'asig_inst_id');
    }

    public function programaciones()
    {
        return $this->belongsToMany(programaciones::class)->withPivot('prog_inst_id', 'prog_inst_id_es');
    }

    public function trabajadores()
    {
        return $this->hasMany(trabajadores::class, 'trab_inst_id');
    }
}
