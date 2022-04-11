<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parroquias extends Model
{
    use HasFactory;

    public function municipios()
    {
        return $this->belongsTo(municipios::class,  'par_mun_id');
    }
}
