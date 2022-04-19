<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agrupaciones extends Model
{
    use HasFactory;

    public function parroquia()
    {
        return $this->belongsTo(parroquias::class,  'agr_par_id');
    }

    public function comunidades()
    {
        return $this->hasMany(comunidades::class, 'com_agr_id');
    }
}
