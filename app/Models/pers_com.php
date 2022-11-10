<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pers_com extends Model
{
    use HasFactory;

    protected $fillable = ['pcom_fecha_act', 'pcom_telf_res', 'pcom_calle', 'pcom_casa', 'pcom_fecha_inac', 'pcom_estado', 'pcom_com_id', 'pcom_pers_id', 'pcom_car_id'];

    public function comunidad()
    {
        return $this->belongsTo(comunidades::class,  'pcom_com_id');
    }

    public function persona()
    {
        return $this->belongsTo(personas::class,  'pcom_pers_id');
    }

    public function cargo()
    {
        return $this->belongsTo(cargos::class,  'pcom_car_id');
    }
}
