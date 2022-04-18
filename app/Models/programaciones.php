<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programaciones extends Model
{
    use HasFactory;

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'prog_inst_id');
        return $this->belongsTo(instituciones::class,  'prog_inst_id_es');
    }
}
