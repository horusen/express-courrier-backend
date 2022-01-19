<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrUrgence
 *
 * @property int $id
 * @property string $libelle
 * @property string $couleur
 * @property string $description
 * @property int $delai
 * @property int $delai_relance1
 * @property int $delai_relance2
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 *
 * @package App\Models
 */
class CrUrgence extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_urgence';

	protected $casts = [
		'delai' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'couleur',
		'delai',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrier::class, 'urgence_id');
	}
}
