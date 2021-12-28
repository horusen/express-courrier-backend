<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
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
 * @property string $numero_facture
 * @property string $devise
 * @property int $montant
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $type
 * @property int $nature
 * @property int $structure
 * @property int $suivi_par
 * @property int $inscription
 *
 * @property \App\Models\CrNature $cr_nature
 * @property \App\Models\CrType $cr_type
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
		'montant' => 'int',
		'type' => 'int',
		'nature' => 'int',
		'structure' => 'int',
		'suivi_par' => 'int',
		'inscription' => 'int'
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
		'numero_facture',
		'devise',
		'montant',
		'type',
		'nature',
		'structure',
		'suivi_par',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'suivi_par');
	}

	public function cr_nature()
	{
		return $this->belongsTo(\App\Models\Courrier\CrNature::class, 'nature');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure');
	}

	public function cr_type()
	{
		return $this->belongsTo(\App\Models\Courrier\CrType::class, 'type');
	}

	public function cr_courrier_entrants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierEntrant::class, 'courrier');
	}

	public function cr_courrier_internes()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierInterne::class, 'courrier');
	}

	public function cr_courrier_sortants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierSortant::class, 'courrier');
	}

	public function cr_fichiers()
	{
		return $this->hasMany(\App\Models\Courrier\CrFichier::class, 'courrier');
	}

	public function cr_reaffectations()
	{
		return $this->hasMany(\App\Models\Courrier\CrReaffectation::class, 'courrier');
	}

	public function cr_traitements()
	{
		return $this->hasMany(\App\Models\Courrier\CrTraitement::class, 'courrier');
	}
}
