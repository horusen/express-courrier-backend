<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Dossier
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $conservation
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\GedConservationRule $ged_conservation_rule
 *
 * @package App\Models
 */
class Dossier extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'dossier';

	protected $casts = [
		'conservation' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'conservation',
		'inscription'
	];

	public function ged_conservation_rule()
	{
		return $this->belongsTo(\App\Models\Ged\GedConservationRule::class, 'conservation');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}
}
