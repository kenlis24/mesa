<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class municipios extends Model
{
    use HasFactory;

    public function estado()
    {
        return $this->belongsTo(estados::class,  'mun_edo_id');
    }    
}
