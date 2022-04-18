<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class progr_flotas extends Model
{
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    public function programacion()
    {
        return $this->belongsTo(programaciones::class,  'pflo_prog_id');
    }

    public function flota()
    {
        return $this->belongsTo(flotas::class,  'pflo_flot_id');
    }
}
