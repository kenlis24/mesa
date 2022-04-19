<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargos extends Model
{
    use HasFactory;

    public function pers_com()
    {
        return $this->hasMany(pers_coms::class, 'pcom_car_id');
    }
}
