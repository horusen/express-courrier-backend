<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrNature
 *
 * @property int $id
 * @property string $libelle
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 *
 * @package App\Models
 */
class CrNature extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_nature';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\Dash\CrCourrier::class, 'nature_id');
	}
}
