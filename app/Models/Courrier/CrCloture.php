<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Apr 2022 10:47:38 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCloture
 *
 * @property int $id
 * @property string $libelle
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 *
 * @package App\Models\Courrier
 */
class CrCloture extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_cloture';

	protected $casts = [
		'inscription_id' => 'int',
		'valider' => 'bool'

	];

	protected $fillable = [
		'libelle',
        'valider',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrier::class, 'cloture_id');
	}
}
