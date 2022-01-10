<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrAmpiliation
 *
 * @property int $id
 * @property int $coordonnee
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\CrCoordonnee $cr_coordonnee
 *
 * @package App\Models
 */
class CrAmpiliation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_ampiliation';

	protected $casts = [
		'coordonnee_id' => 'int',
		'courrier_id' => 'int',
		'inscription_id' => 'int',
	];

	protected $fillable = [
		'coordonnee_id',
		'courrier_id',
		'inscription_id'
	];

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'coordonnee_id');
	}

    public function cr_courrier_sortant()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrierSortant::class, 'courrier_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}
}
