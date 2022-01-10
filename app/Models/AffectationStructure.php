<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class AffectationStructure
 * 
 * @property int $id
 * @property int $user
 * @property int $structure
 * @property int $fonction
 * @property int $droit_acces
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\DroitAcce $droit_acce
 *
 * @package App\Models
 */
class AffectationStructure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'user' => 'int',
		'structure' => 'int',
		'fonction' => 'int',
		'droit_acces' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'user',
		'structure',
		'fonction',
		'droit_acces',
		'inscription'
	];

	public function droit_acce()
	{
		return $this->belongsTo(\App\Models\DroitAcce::class, 'droit_acces');
	}

	public function fonction()
	{
		return $this->belongsTo(\App\Models\Fonction::class, 'fonction');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'user');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure');
	}
}
