<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conf_rol_inst extends Model
{
    use HasFactory;

    protected $fillable = ['rins_nombre', 'rins_estado'];
}
