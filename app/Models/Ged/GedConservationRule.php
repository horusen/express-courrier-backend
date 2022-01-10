<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedConservationRule
 *
 * @property int $id
 * @property string $libelle
 * @property int $duree
 * @property string $description
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $dossiers
 *
 * @package App\Models
 */
class GedConservationRule extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_conservation_rule';

	protected $casts = [
		'duree' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'duree',
		'description',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function dossiers()
	{
		return $this->hasMany(\App\Models\Dossier::class, 'conservation_id');
	}
}
