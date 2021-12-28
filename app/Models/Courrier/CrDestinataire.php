<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrDestinataire
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
class CrDestinataire extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_destinataire';

	protected $casts = [
		'coordonnee' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'coordonnee',
		'inscription'
	];

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'coordonnee');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}
}
