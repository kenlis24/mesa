<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelo_vehi extends Model
{
    protected $table = "modelo_vehi";
    use HasFactory;

    public function marca()
    {
        return $this->belongsTo(marca_vehi::class,  'mod_mca_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(vehiculos::class, 'vehi_mod_id');
    }
}
