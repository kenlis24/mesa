<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marca_vehi extends Model
{
    protected $table = "marca_vehi";
    use HasFactory;

    public function modelos()
    {
        return $this->hasMany(modelo_vehi::class, 'mod_mca_id');
    }
}
