<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
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
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Inscription $inscription
 *
 * @package App\Models
 */
class CrSuivi extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_suivi';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'libelle',
		'date',
		'moyen',
		'resultat',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}
}
