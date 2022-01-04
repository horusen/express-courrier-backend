<?php

namespace App\Models\Structure;

use App\Models\Courrier\CrAutorisationPersonneStructure;
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

    protected $appends = ['responsable', 'charge_courriers'];

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

    private function responsables()
    {
        return $this->belongsToMany(Inscription::class, ResponsableStructure::class, 'structure', 'responsable');
    }

    public  function charger_courriers()
    {
        return $this->belongsToMany(Inscription::class, CrAutorisationPersonneStructure::class, 'structure_id', 'personne_id');
    }

    public function getChargeCourriersAttribute()
    {
        return $this->charger_courriers()->whereDoesntHave('isResponsableStructure', function ($q) {
            $q->where('structures.id', $this->id);
        })->get();
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
