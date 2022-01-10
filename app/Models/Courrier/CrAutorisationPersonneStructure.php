<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrAutorisationPersonneStructure
 *
 * @property int $id
 * @property bool $envoyer_courrier
 * @property bool $consulter_entrant
 * @property bool $consulter_sortant
 * @property bool $ajouter_personne
 * @property bool $retirer_personne
 * @property bool $affecter_courrier
 * @property int $structure
 * @property int $personne
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @package App\Models
 */
class CrAutorisationPersonneStructure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_autorisation_personne_structure';

	protected $casts = [
		'envoyer_courrier' => 'bool',
		'consulter_entrant' => 'bool',
		'consulter_sortant' => 'bool',
		'ajouter_personne' => 'bool',
		'retirer_personne' => 'bool',
		'affecter_courrier' => 'bool',
		'structure_id' => 'int',
		'personne' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'envoyer_courrier',
		'consulter_entrant',
		'consulter_sortant',
		'ajouter_personne',
		'retirer_personne',
		'affecter_courrier',
		'structure_id',
		'personne',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

    public function personne_inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'personne');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure_id');
	}
}
