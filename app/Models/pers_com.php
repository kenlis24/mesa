<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pers_com extends Model
{
    use HasFactory;

    public function agrupacion()
    {
        return $this->belongsTo(agrupaciones::class,  'pcom_agr_id');
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
