<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class FichierType
 *
 * @property int $id
 * @property string $libelle
 * @property string $icon
 * @property string $extension
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $fichiers
 *
 * @package App\Models
 */
class FichierType extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'fichier_type';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'icon',
		'extension',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

	public function fichiers()
	{
		return $this->hasMany(\App\Models\Ged\Fichier::class, 'type');
	}
}
