<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Dash;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrier
 *
 * @property int $id
 * @property string $libelle
 * @property string $objet
 * @property \Carbon\Carbon $date_redaction
 * @property string $commentaire
 * @property bool $valider
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $nature_id
 * @property int $type_id
 * @property int $urgence_id
 * @property int $structure_id
 * @property int $suivi_par
 * @property int $statut_id
 * @property int $inscription_id
 * @property int $current_etape_id
 * @property int $cloture_id
 * @property \Carbon\Carbon $date_cloture
 * @property string $message_cloture
 *
 * @property \App\Models\CrCloture $cr_cloture
 * @property \App\Models\CrCourrierEtape $cr_courrier_etape
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Courrier\Structure $structure
 * @property \App\Models\Courrier\CrNature $cr_nature
 * @property \App\Models\Courrier\CrStatut $cr_statut
 * @property \App\Models\Courrier\CrType $cr_type
 * @property \App\Models\Courrier\CrUrgence $cr_urgence
 * @property \Illuminate\Database\Eloquent\Collection $cr_affectation_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_entrants
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_etapes
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_internes
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_sortants
 * @property \Illuminate\Database\Eloquent\Collection $cr_fichiers
 * @property \Illuminate\Database\Eloquent\Collection $cr_reaffectations
 * @property \Illuminate\Database\Eloquent\Collection $cr_traitements
 *
 * @package App\Models
 */
class CrCourrier extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes, ApiRequestConsumer;
    protected $table = 'cr_courrier';

    protected $casts = [
        'valider' => 'bool',
        'type_id' => 'int',
        'nature_id' => 'int',
        'urgence_id' => 'int',
        'statut_id' => 'int',
        'structure_id' => 'int',
        'suivi_par' => 'int',
        'inscription_id' => 'int',
        'current_etape_id' => 'int',
        'cloture_id' => 'int'
    ];

    protected $dates = [
        'date_redaction',
        'date_limit',
        'date_cloture'
    ];

    protected $fillable = [
        'libelle',
        'objet',
        'date_redaction',
        'commentaire',
        'valider',
        'nature_id',
        'type_id',
        'urgence_id',
        'structure_id',
        'suivi_par',
        'statut_id',
        'inscription_id',
        'current_etape_id',
        'cloture_id',
        'date_cloture',
        'message_cloture',
        'date_limit'
    ];

    public function inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
    }

    public function suivi_par_inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class, 'suivi_par');
    }

    public function cr_cloture()
    {
        return $this->belongsTo(\App\Models\Courrier\CrCloture::class, 'cloture_id');
    }

    public function cr_courrier_etape()
    {
        return $this->belongsTo(\App\Models\Courrier\CrCourrierEtape::class, 'current_etape_id');
    }


    public function structure()
    {
        return $this->belongsTo(\App\Models\Structure::class);
    }

    public function cr_reaffected_structures()
    {
        return $this->belongsToMany(\App\Models\Structure::class, 'cr_reaffectation', 'courrier_id', 'structure_id');
    }

    public function cr_reaffected_inscriptions()
    {
        return $this->belongsToMany(\App\Models\Inscription::class, 'cr_reaffectation', 'courrier_id', 'suivi_par');
    }

    public function cr_reaffected_structure()
    {
        return $this->hasOneThrough(\App\Models\Structure::class, \App\Models\Courrier\CrReaffectation::class, 'courrier_id', 'id', 'id', 'structure_id');
    }

    public function cr_type()
    {
        return $this->belongsTo(\App\Models\Courrier\CrType::class, 'type_id');
    }

    public function cr_nature()
    {
        return $this->belongsTo(\App\Models\Courrier\CrNature::class, 'nature_id');
    }

    public function cr_urgence()
    {
        return $this->belongsTo(\App\Models\Courrier\CrUrgence::class, 'urgence_id');
    }

    public function cr_affectation_courriers()
    {
        return $this->hasMany(\App\Models\Courrier\CrAffectationCourrier::class, 'courrier');
    }


    public function cr_statut()
    {
        return $this->belongsTo(\App\Models\Courrier\CrStatut::class, 'statut_id');
    }

    public function cr_courrier_entrants()
    {
        return $this->hasMany(\App\Models\Dash\CrCourrierEntrant::class, 'courrier_id');
    }

    public function cr_courrier_etapes()
    {
        return $this->hasMany(\App\Models\Courrier\CrCourrierEtape::class, 'courrier_id');
    }

    public function cr_courrier_internes()
    {
        return $this->hasMany(\App\Models\Courrier\CrCourrierEntrant::class, 'courrier_id');
    }

    public function cr_courrier_sortants()
    {
        return $this->hasMany(\App\Models\Dash\CrCourrierSortant::class, 'courrier_id');
    }

    public function cr_fichiers()
    {
        return $this->hasMany(\App\Models\Courrier\CrFichier::class, 'courrier_id');
    }

    public function cr_reaffectations()
    {
        return $this->hasMany(\App\Models\Courrier\CrReaffectation::class, 'courrier_id');
    }

    public function cr_traitements()
    {
        return $this->hasMany(\App\Models\Courrier\CrTraitement::class, 'courrier_id');
    }

    public function cr_commentaires()
    {
        return $this->belongsToMany(\App\Models\Courrier\CrCourrier::class, 'cr_affectation_commentaire_courrier', 'courrier', 'commentaire');
    }

    public function structure_copie_informations()
    {
        return $this->belongsToMany(\App\Models\Structure::class, 'cr_structure_copie_information', 'courrier_id', 'structure_id');
    }

    public function structure_copie_traitements()
    {
        return $this->belongsToMany(\App\Models\Structure::class, 'cr_structure_copie_traitement', 'courrier_id', 'structure_id');
    }
}
