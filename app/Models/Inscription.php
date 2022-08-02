<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Inscription
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property \Carbon\Carbon $date_naissance
 * @property string $lieu_naissance
 * @property string $identifiant
 * @property string $telephone
 * @property string $photo
 * @property string $sexe
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $affectation_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_actions
 * @property \Illuminate\Database\Eloquent\Collection $cr_ampiliations
 * @property \Illuminate\Database\Eloquent\Collection $cr_autorisation_personne_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_coordonnees
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_entrants
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_internes
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_sortants
 * @property \Illuminate\Database\Eloquent\Collection $cr_destinataires
 * @property \Illuminate\Database\Eloquent\Collection $cr_fichiers
 * @property \Illuminate\Database\Eloquent\Collection $cr_moyen_suivis
 * @property \Illuminate\Database\Eloquent\Collection $cr_natures
 * @property \Illuminate\Database\Eloquent\Collection $cr_reaffectations
 * @property \Illuminate\Database\Eloquent\Collection $cr_structure_copies
 * @property \Illuminate\Database\Eloquent\Collection $cr_suivis
 * @property \Illuminate\Database\Eloquent\Collection $cr_traitements
 * @property \Illuminate\Database\Eloquent\Collection $cr_types
 * @property \Illuminate\Database\Eloquent\Collection $cr_urgences
 * @property \Illuminate\Database\Eloquent\Collection $dossiers
 * @property \Illuminate\Database\Eloquent\Collection $droit_acces
 * @property \Illuminate\Database\Eloquent\Collection $fichiers
 * @property \Illuminate\Database\Eloquent\Collection $fichier_types
 * @property \Illuminate\Database\Eloquent\Collection $fonctions
 * @property \Illuminate\Database\Eloquent\Collection $ged_conservation_rules
 * @property \Illuminate\Database\Eloquent\Collection $ged_element_personnes
 * @property \Illuminate\Database\Eloquent\Collection $ged_element_structures
 * @property \Illuminate\Database\Eloquent\Collection $ged_favoris
 * @property \Illuminate\Database\Eloquent\Collection $ged_partages
 * @property \Illuminate\Database\Eloquent\Collection $inscriptions
 * @property \Illuminate\Database\Eloquent\Collection $log_activities
 * @property \Illuminate\Database\Eloquent\Collection $structures
 * @property \Illuminate\Database\Eloquent\Collection $type_admins
 * @property \Illuminate\Database\Eloquent\Collection $type_structures
 *
 * @package App\Models
 */
class Inscription extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'inscription';

    protected $casts = [
        'inscription' => 'int'
    ];

    protected $dates = [
        'date_naissance'
    ];

    protected $fillable = [
        'prenom',
        'nom',
        'date_naissance',
        'lieu_naissance',
        'identifiant',
        'telephone',
        'photo',
        'sexe',
        'inscription'
    ];

    public function getPhotoAttribute()
    {
        if ($this->attributes['photo']) {
            $document_scanne = "http://localhost:8000/storage/" . $this->attributes['photo'];
            return $document_scanne;
        }
        return 0;
    }

    public function inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
    }


    public function affectation_structures()
    {
        return $this->hasMany(\App\Models\AffectationStructure::class, 'user');
    }

    public function cr_actions()
    {
        return $this->hasMany(\App\Models\CrAction::class, 'inscription');
    }

    public function cr_ampiliations()
    {
        return $this->hasMany(\App\Models\CrAmpiliation::class, 'inscription');
    }

    public function cr_autorisation_personne_structures()
    {
        return $this->hasMany(\App\Models\CrAutorisationPersonneStructure::class, 'personne');
    }

    public function cr_coordonnees()
    {
        return $this->hasMany(\App\Models\CrCoordonnee::class, 'inscription');
    }

    public function cr_courriers()
    {
        return $this->hasMany(\App\Models\CrCourrier::class, 'suivi_par');
    }

    public function cr_courrier_entrants()
    {
        return $this->hasMany(\App\Models\CrCourrierEntrant::class, 'responsable');
    }

    public function cr_courrier_internes()
    {
        return $this->hasMany(\App\Models\CrCourrierInterne::class, 'inscription');
    }

    public function cr_courrier_sortants()
    {
        return $this->hasMany(\App\Models\CrCourrierSortant::class, 'inscription');
    }

    public function cr_destinataires()
    {
        return $this->hasMany(\App\Models\CrDestinataire::class, 'inscription');
    }

    public function cr_fichiers()
    {
        return $this->hasMany(\App\Models\CrFichier::class, 'inscription');
    }

    public function cr_moyen_suivis()
    {
        return $this->hasMany(\App\Models\CrMoyenSuivi::class, 'inscription');
    }

    public function cr_natures()
    {
        return $this->hasMany(\App\Models\CrNature::class, 'inscription');
    }

    public function cr_reaffectations()
    {
        return $this->hasMany(\App\Models\CrReaffectation::class, 'suivi_par');
    }

    public function cr_structure_copies()
    {
        return $this->hasMany(\App\Models\CrStructureCopie::class, 'inscription');
    }

    public function cr_suivis()
    {
        return $this->hasMany(\App\Models\CrSuivi::class, 'inscription');
    }

    public function cr_traitements()
    {
        return $this->hasMany(\App\Models\CrTraitement::class, 'inscription');
    }

    public function cr_types()
    {
        return $this->hasMany(\App\Models\CrType::class, 'inscription');
    }

    public function cr_urgences()
    {
        return $this->hasMany(\App\Models\CrUrgence::class, 'inscription');
    }

    public function dossiers()
    {
        return $this->hasMany(\App\Models\Dossier::class, 'inscription');
    }

    public function droit_acces()
    {
        return $this->hasMany(\App\Models\DroitAcce::class, 'inscription');
    }

    public function fichiers()
    {
        return $this->hasMany(\App\Models\Fichier::class, 'inscription');
    }

    public function fichier_types()
    {
        return $this->hasMany(\App\Models\FichierType::class, 'inscription');
    }

    public function fonctions()
    {
        return $this->hasMany(\App\Models\Fonction::class, 'inscription');
    }

    public function ged_conservation_rules()
    {
        return $this->hasMany(\App\Models\GedConservationRule::class, 'inscription');
    }

    public function ged_element_personnes()
    {
        return $this->hasMany(\App\Models\GedElementPersonne::class, 'personne');
    }

    public function ged_element_structures()
    {
        return $this->hasMany(\App\Models\GedElementStructure::class, 'inscription');
    }

    public function ged_favoris()
    {
        return $this->hasMany(\App\Models\GedFavori::class, 'inscription');
    }

    public function ged_partages()
    {
        return $this->hasMany(\App\Models\GedPartage::class, 'personne');
    }

    public function inscriptions()
    {
        return $this->hasMany(\App\Models\Inscription::class, 'inscription');
    }

    public function log_activities()
    {
        return $this->hasMany(\App\Models\LogActivity::class, 'inscription');
    }

    public function structures()
    {
        return $this->hasMany(\App\Models\Structure::class, 'inscription');
    }

    public function estDansStructures()
    {
        return $this->belongsToMany(\App\Models\Structure::class, AffectationStructure::class, 'user', 'structure');
    }

    public function type_admins()
    {
        return $this->hasMany(\App\Models\TypeAdmin::class, 'inscription');
    }

    public function type_structures()
    {
        return $this->hasMany(\App\Models\TypeStructure::class, 'inscription');
    }

    public function affectation_courrier()
    {
        return $this->morphOne(\App\Models\Courrier\CrAffectationCourrier::class, 'objet');
    }
}
