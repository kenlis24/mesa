<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agrupaciones extends Model
{
    use HasFactory;

    public function parroquias()
    {
        return $this->belongsTo(parroquias::class,  'par_mun_id');
    }
}
