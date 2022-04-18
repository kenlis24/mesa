<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comunidades extends Model
{
    use HasFactory;

    public function agrupacion()
    {
        return $this->belongsTo(agrupaciones::class,  'agr_par_id');
    }
}
