<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Fichier
 *
 * @property int $id
 * @property int $type
 * @property string $libelle
 * @property string $fichier
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\FichierType $fichier_type
 * @property \Illuminate\Database\Eloquent\Collection $cr_fichiers
 *
 * @package App\Models
 */
class Fichier extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'fichier';

	protected $casts = [
		'type' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'type',
		'libelle',
		'fichier',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function fichier_type()
	{
		return $this->belongsTo(\App\Models\Ged\FichierType::class, 'type');
	}

	public function cr_fichiers()
	{
		return $this->hasMany(\App\Models\Courrier\CrFichier::class, 'fichier');
	}
}
