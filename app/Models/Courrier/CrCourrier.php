<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

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
 * @property int $type_id
 * @property int $urgence_id
 * @property int $structure_id
 * @property int $suivi_par
 * @property int $inscription_id
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Structure $structure
 * @property \App\Models\Courrier\CrType $cr_type
 * @property \App\Models\Courrier\CrUrgence $cr_urgence
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_entrants
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
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier';

	protected $casts = [
		'valider' => 'bool',
		'type_id' => 'int',
		'nature_id' => 'int',
		'urgence_id' => 'int',
		'statut_id' => 'int',
		'structure_id' => 'int',
		'suivi_par' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_redaction'
	];

	protected $fillable = [
		'libelle',
		'objet',
		'date_redaction',
		'commentaire',
		'valider',
		'type_id',
		'nature_id',
		'urgence_id',
		'statut_id',
		'structure_id',
		'suivi_par',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'suivi_par');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class);
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

    public function cr_statut()
	{
		return $this->belongsTo(\App\Models\Courrier\CrStatut::class, 'statut_id');
	}

	public function cr_courrier_entrants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierEntrant::class, 'courrier_id');
	}

	public function cr_courrier_internes()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierInterne::class, 'courrier_id');
	}

	public function cr_courrier_sortants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierSortant::class, 'courrier_id');
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
}
