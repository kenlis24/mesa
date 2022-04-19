<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instituciones extends Model
{
    use HasFactory;

    public function parroquia()
    {
        return $this->belongsTo(parroquias::class,  'inst_par_id');
    }

    public function area_serevicio()
    {
        return $this->belongsTo(area_serevicios::class,  'inst_aser_id');
    }

    public function grupo()
    {
        return $this->belongsTo(grupos::class,  'inst_gpo_id');
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
        return $this->hasMany(programaciones::class, 'prog_inst_id');
    }

    public function trabajadores()
    {
        return $this->hasMany(trabajadores::class, 'trab_inst_id');
    }
}
