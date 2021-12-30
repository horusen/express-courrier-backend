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
		'courrier_id' => 'int',
		'expediteur' => 'int',
		'responsable' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_arrive'
	];

	protected $fillable = [
		'date_arrive',
		'courrier_id',
		'expediteur',
		'responsable',
		'inscription_id'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
	}

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'expediteur');
	}

    public function responsable_inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}
}
