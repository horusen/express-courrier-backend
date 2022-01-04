<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrierSortant
 *
 * @property int $id
 * @property \Carbon\Carbon $date_envoie
 * @property string $action_depot
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $courrier
 * @property int $courrier_entrant
 * @property int $inscription
 *
 * @property \App\Models\CrCourrier $cr_courrier
 *
 * @package App\Models
 */
class CrCourrierSortant extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_sortant';

	protected $casts = [
		'courrier_id' => 'int',
		'courrier_entrant' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_envoie'
	];

	protected $fillable = [
		'date_envoie',
		'action_depot',
		'courrier_id',
		'courrier_entrant',
		'inscription_id'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
	}

    public function cr_courrier_entrant()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_entrant');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}
}
