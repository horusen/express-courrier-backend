<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrReaffectation
 *
 * @property int $id
 * @property string $libelle
 * @property int $courrier
 * @property int $structure
 * @property int $suivi_par
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\CrCourrier $cr_courrier
 *
 * @package App\Models
 */
class CrReaffectation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_reaffectation';

	protected $casts = [
		'courrier' => 'int',
		'structure' => 'int',
		'suivi_par' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'courrier',
		'structure',
		'suivi_par',
		'inscription'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'suivi_par');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Courrier\Structure::class, 'structure');
	}
}
