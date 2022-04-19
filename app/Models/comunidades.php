<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comunidades extends Model
{
    use HasFactory;

    public function agrupacion()
    {
        return $this->belongsTo(agrupaciones::class,  'com_agr_id');
    }

    public function pers_com()
    {
        return $this->hasMany(pers_coms::class, 'pcom_com_id');
    }
}
