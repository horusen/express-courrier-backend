<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedConservationRule
 *
 * @property int $id
 * @property string $libelle
 * @property int $duree_annee
 * @property string $description
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $dossiers
 *
 * @package App\Models
 */
class GedConservationRule extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_conservation_rule';

	protected $casts = [
		'duree_annee' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'duree_annee',
		'description',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function dossiers()
	{
		return $this->hasMany(\App\Models\Ged\Dossier::class, 'conservation');
	}
}
