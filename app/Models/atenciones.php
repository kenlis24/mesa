<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class atenciones extends Model
{
    use HasFactory;

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'aten_inst_id');
    }
}
