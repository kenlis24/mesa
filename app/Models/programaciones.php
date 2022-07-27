<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programaciones extends Model
{
    use HasFactory;

    protected $fillable = ['prog_fecha', 'prog_tipo_comb', 'prog_lts', 'prog_condicion', 'prog_observacion', 'prog_estado', 'prog_inst_id', 'prog_inst_id_es'];

    public function institucion()
    {
        //return $this->belongsToMany(instituciones::class,  'prog_inst_id', 'prog_inst_id_es');
        return $this->belongsTo(instituciones::class, 'prog_inst_id', 'id');
    }

    public function progr_flotas()
    {
        return $this->hasMany(progr_flotas::class, 'pflo_prog_id');
    }
}
