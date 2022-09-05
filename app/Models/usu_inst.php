<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usu_inst extends Model
{
    protected $table = "usu_insts";
    use HasFactory;

    protected $fillable = ['usui_fecha_act', 'usui_fecha_inac', 'usui_estado', 'usui_observacion', 'usui_inst_id', 'usui_usu_id'];

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'usui_inst_id');
    }
}
