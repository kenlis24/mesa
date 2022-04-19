<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_servicios extends Model
{
    use HasFactory;

    public function instituciones()
    {
        return $this->hasMany(instituciones::class, 'inst_aser_id');
    }
}
