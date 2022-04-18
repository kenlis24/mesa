<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class flotas extends Model
{
    use HasFactory;

    public function trabajador()
    {
        return $this->belongsTo(trabajadores::class,  'flot_trab_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(vehiculos::class,  'flot_vehi_id');
    }
}
