<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instituciones extends Model
{
    use HasFactory;    

    public function area_serevicio()
    {
        return $this->belongsTo(area_serevicios::class,  'asig_inst_id');
    }
}
