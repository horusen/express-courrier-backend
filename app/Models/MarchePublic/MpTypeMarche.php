<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpTypeMarche
 *
 * @property int $id
 * @property string $libelle
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $mp_marches
 *
 * @package App\Models
 */
class MpTypeMarche extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_type_marche';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'inscription_id'
	];

    protected $appends = ['cant_delete'];

	public function getCantDeleteAttribute()
	{
		return $this->mp_marches()->count();
	}


	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_marches()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpMarche::class, 'type_marche_id');
	}
}
