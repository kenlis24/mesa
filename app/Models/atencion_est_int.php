<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class atencion_est_int extends Model
{
    protected $table = "atencion_est_ints";
    use HasFactory;
    protected $fillable = [
        'atei_usu_id', 'atei_usuins_id', 'atei_usui_mod_id', 'atei_placa', 'atei_tipo_vehi',
        'atei_tipo_comb', 'atei_litros', 'atei_cedula', 'atei_telefono', 'atei_fecha', 'atei_estado'
    ];
}
