<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends Model
{
    use SoftDeletes;
    protected $table = 'structures';
    protected $guarded = [];
    protected $with = ['type', 'sous_structures', 'employes', 'responsables'];
    // protected $appends = ['employes'];

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

    // public function getEmployesAttribute()
    // {

    //     // if($this->has('sous_structures')) {
    //     //     return $this->sous_structures()->get
    //     // }


    //     // return $this->employes()->limit(5)->get();
    // }

    public function employes()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'structure', 'user')->where('affectation_structures.is_responsable', false);
    }

    public function responsables()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'structure', 'user')->where('affectation_structures.is_responsable', true);
    }
}
