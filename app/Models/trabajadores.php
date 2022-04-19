<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trabajadores extends Model
{
    use HasFactory;

    public function institucion()
    {
        return $this->belongsTo(instituciones::class,  'trab_inst_id');
    }

    public function persona()
    {
        return $this->belongsTo(personas::class,  'trab_pers_id');
    }

    public function instituciones()
    {
        return $this->hasMany(instituciones::class, 'inst_aser_id');
    }

    public function flotas()
    {
        return $this->hasMany(flotas::class, 'flot_trab_id');
    }
}
