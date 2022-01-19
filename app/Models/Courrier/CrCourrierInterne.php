<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrierInterne
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $courrier_id
 * @property int $inscription_id
 * 
 * @property \App\Models\Courrier\CrCourrier $cr_courrier
 * @property \App\Models\Inscription $inscription
 *
 * @package App\Models
 */
class CrCourrierInterne extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_interne';

	protected $casts = [
		'courrier_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'courrier_id',
		'inscription_id'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}
}
