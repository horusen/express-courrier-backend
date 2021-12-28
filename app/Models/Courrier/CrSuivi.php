<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrSuivi
 *
 * @property int $id
 * @property string $libelle
 * @property \Carbon\Carbon $date
 * @property string $moyen
 * @property string $resultat
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @package App\Models
 */
class CrSuivi extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_suivi';

	protected $casts = [
		'inscription' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'libelle',
		'date',
		'moyen',
		'resultat',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}
}
