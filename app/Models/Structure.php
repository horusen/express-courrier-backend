<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models;

use App\Models\Ged\Dossier;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Structure
 *
 * @property int $id
 * @property string $libelle
 * @property string $cigle
 * @property string $description
 * @property int $type
 * @property int $parent
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Structure $structure
 * @property \App\Models\TypeStructure $type_structure
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $affectation_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_autorisation_personne_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_reaffectations
 * @property \Illuminate\Database\Eloquent\Collection $cr_structure_copies
 * @property \Illuminate\Database\Eloquent\Collection $ged_elements
 * @property \Illuminate\Database\Eloquent\Collection $structures
 *
 * @package App\Models
 */
class Structure extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $casts = [
        'type' => 'int',
        'parent' => 'int',
        'inscription' => 'int'
    ];

    protected $fillable = [
        'libelle',
        'cigle',
        'description',
        'type',
        'parent',
        'inscription'
    ];

    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            $document_scanne = "http://localhost:8000/storage/" . $this->attributes['image'];
            return $document_scanne;
        }
        return 0;
    }
    protected $appends = ['dossiers'];

    public function getDossiersAttribute()
    {
        $id = $this->attributes['id'];
        return Dossier::whereHas('ged_element.structures', function ($query) use ($id) {
            $query->where('structures.id', $id);
        })->with('dossiers')->get();
    }

    public function inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
    }

    public function structure()
    {
        return $this->belongsTo(\App\Models\Structure::class, 'parent');
    }

    public function type_structure()
    {
        return $this->belongsTo(\App\Models\TypeStructure::class, 'type');
    }



    public function affectation_structures()
    {
        return $this->hasMany(\App\Models\AffectationStructure::class, 'structure');
    }

    public function cr_autorisation_personne_structures()
    {
        return $this->hasMany(\App\Models\CrAutorisationPersonneStructure::class, 'structure');
    }

    public function cr_courriers()
    {
        return $this->hasMany(\App\Models\CrCourrier::class, 'structure');
    }

    public function cr_reaffectations()
    {
        return $this->hasMany(\App\Models\CrReaffectation::class, 'structure');
    }

    public function cr_structure_copies()
    {
        return $this->hasMany(\App\Models\CrStructureCopie::class, 'structure');
    }

    public function ged_elements()
    {
        return $this->belongsToMany(\App\Models\GedElement::class, 'ged_element_structure', 'structure', 'element')
            ->withPivot('id', 'inscription', 'deleted_at')
            ->withTimestamps();
    }

    public function structures()
    {
        return $this->hasMany(\App\Models\Structure::class, 'parent');
    }

    public function _employes()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'structure', 'user');
    }

    public function affectation_courrier()
    {
        return $this->morphOne(\App\Models\Courrier\CrAffectationCourrier::class, 'objet');
    }

    public function responsables()
    {
        return $this->belongsToMany(Inscription::class, ResponsableStructure::class, 'structure', 'responsable')->select(['inscription.id', 'prenom', 'nom', 'photo']);
    }
}
