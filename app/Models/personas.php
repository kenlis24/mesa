<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personas extends Model
{
    use HasFactory;

    public function vehiculos()
    {
        return $this->hasMany(vehiculos::class, 'vehi_pers_id');
    }

    public function pers_com()
    {
        return $this->hasMany(pers_coms::class, 'pcom_pers_id');
    }

    public function trabajadores()
    {
        return $this->hasMany(trabajadores::class, 'trab_pers_id');
    }
}
