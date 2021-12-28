<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrierEntrant
 *
 * @property int $id
 * @property \Carbon\Carbon $date_arrive
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $courrier
 * @property int $expediteur
 * @property int $responsable
 * @property int $inscription
 *
 * @property \App\Models\CrCourrier $cr_courrier
 * @property \App\Models\CrCoordonnee $cr_coordonnee
 *
 * @package App\Models
 */
class CrCourrierEntrant extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_entrant';

	protected $casts = [
		'courrier' => 'int',
		'expediteur' => 'int',
		'responsable' => 'int',
		'inscription' => 'int'
	];

	protected $dates = [
		'date_arrive'
	];

	protected $fillable = [
		'date_arrive',
		'courrier',
		'expediteur',
		'responsable',
		'inscription'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier');
	}

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'expediteur');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable');
	}
}
