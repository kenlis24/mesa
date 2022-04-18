<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usu_inst extends Model
{
    use HasFactory;

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'usui_inst_id');
    }
}
