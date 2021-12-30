<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrTraitement
 *
 * @property int $id
 * @property string $action
 * @property string $commentaire
 * @property int $courrier
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\CrCourrier $cr_courrier
 *
 * @package App\Models
 */
class CrTraitement extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_traitement';

	protected $casts = [
		'courrier' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'action',
		'commentaire',
		'courrier',
		'inscription'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}
}
