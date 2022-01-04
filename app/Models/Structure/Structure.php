<?php

namespace App\Models\Structure;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends Model
{
    use SoftDeletes;
    protected $table = 'structures';
    protected $guarded = [];
    // protected $hidden = ['image'];
    protected $with = ['type', 'employes'];

    protected $appends = ['responsable'];

    public function type()
    {
        return $this->belongsTo(TypeStructure::class, 'type');
    }

    public function parent()
    {
        return $this->belongsTo(Structure::class, 'parent');
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function sous_structures()
    {
        return $this->hasMany(Structure::class, 'parent');
    }


    public function employes()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'structure', 'user');
    }

    public function responsables()
    {
        return $this->belongsToMany(Inscription::class, ResponsableStructure::class, 'structure', 'responsable');
    }

    public function getResponsableAttribute()
    {
        return $this->responsables()->first();
    }

    protected function getImageAttribute($value)
    {
        return env('IMAGE_PREFIX_URL') . '/storage/' . $value;
    }
}
