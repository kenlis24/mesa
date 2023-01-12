<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehiculos extends Model
{
    use HasFactory;

    protected $fillable = ['vehi_placa', 'vehi_tag', 'vehi_tipo_vehi', 'vehi_tipo_comb', 'vehi_capacidad_Lts', 'vehi_estado', 'vehi_observacion', 'vehi_pers_id', 'vehi_mod_id'];

    public function persona()
    {
        return $this->belongsTo(personas::class,  'vehi_pers_id');
    }

    public function modelo_vehi()
    {
        return $this->belongsTo(modelo_vehi::class,  'vehi_mod_id');
    }

    public function flota()
    {
        return $this->hasMany(flotas::class, 'flot_vehi_id');
    }
}
