<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class flotas extends Model
{
    use HasFactory;
    protected $fillable = ['flot_fecha_act', 'flot_estado', 'flot_trab_id', 'flot_vehi_id'];

    public function trabajador()
    {
        return $this->belongsTo(trabajadores::class,  'flot_trab_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(vehiculos::class,  'flot_vehi_id');
    }

    public function progr_flotas()
    {
        return $this->hasMany(progr_flotas::class, 'pflo_flot_id');
    }
}
