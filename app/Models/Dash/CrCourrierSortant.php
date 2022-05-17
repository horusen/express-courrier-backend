<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Dash;

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
 * @property int $courrier_id
 * @property int $courrier_entrant_id
 * @property int $inscription_id
 *
 * @property \App\Models\Courrier\CrCourrierEntrant $cr_courrier_entrant
 * @property \App\Models\Courrier\CrCourrier $cr_courrier
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_ampiliations
 * @property \Illuminate\Database\Eloquent\Collection $cr_destinataires
 *
 * @package App\Models
 */
class CrCourrierSortant extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_sortant';

	protected $casts = [
		'courrier_id' => 'int',
		'courrier_entrant_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_envoie'
	];

	protected $fillable = [
		'date_envoie',
		'action_depot',
		'courrier_id',
		'courrier_entrant_id',
		'inscription_id'
	];

	public function cr_courrier_entrant()
	{
		return $this->belongsTo(\App\Models\Dash\CrCourrierEntrant::class, 'courrier_entrant_id');
	}

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Dash\CrCourrier::class, 'courrier_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_ampiliations()
	{
		return $this->hasMany(\App\Models\Courrier\CrAmpiliation::class, 'courrier_id');
	}

	public function cr_destinataires()
	{
		return $this->hasMany(\App\Models\Courrier\CrDestinataire::class, 'courrier_id');
	}
}
