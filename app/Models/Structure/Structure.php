<?php

namespace App\Models\Structure;

use App\Models\Admin;
use App\Models\Courrier\CrAutorisationPersonneStructure;
use App\Models\Structure\Admin as StructureAdmin;
use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\NodeTrait;

class Structure extends Model
{
    use SoftDeletes, NodeTrait;
    protected $table = 'structures';
    protected $guarded = [];
    // protected $hidden = ['parent_id'];
    protected $with = ['type', 'parent'];

    protected $appends = ['has_sous_structures', 'responsable', 'isUserAdmin'];

    public function type()
    {
        return $this->belongsTo(TypeStructure::class, 'type');
    }

    public function parent()
    {
        return $this->belongsTo(Structure::class, 'parent_id');
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function sous_structures()
    {
        return $this->children();
    }


    public function _employes()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'structure', 'user');
    }

    protected function getHasSousStructuresAttribute()
    {
        $sous_structure = $this->sous_structures()->first();
        return isset($sous_structure);
    }

    protected function getIsUserAdminAttribute()
    {
        $admin = $this->admins()->where('user', Auth::id())->first();
        return isset($admin);
    }


    public function admins()
    {
        return $this->hasMany(StructureAdmin::class, 'structure');
    }

    public function affectation_structures()
    {
        return $this->hasMany(AffectationStructure::class, 'structure');
    }


    // TODO: recuperer de maniere plus efficiente les employes
    public function getEmployesAttribute()
    {
        if (($this->descendants()->count())) {
            return $this->descendants()->has('_employes')->with(['_employes'])->get()->flatMap(function ($structure) {
                return $structure->employes;
            });
        }

        return $this->_employes()->get();
    }

    public function responsables()
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
