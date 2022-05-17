<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'structures';

     public function cr_courriers()
    {
        return $this->hasMany(\App\Models\Dash\CrCourrier::class, 'structure_id');
    }
    public function type_structure()
    {
        return $this->belongsTo(\App\Models\TypeStructure::class, 'type');
    }
}
