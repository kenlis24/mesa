<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignaciones extends Model
{
    use HasFactory;

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'asig_inst_id');
    }
}
