<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 26 Apr 2022 13:10:00 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrProvenance
 *
 * @property int $id
 * @property string $libelle
 * @property bool $externe
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_entrants
 *
 * @package App\Models
 */
class CrProvenance extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_provenance';

	protected $casts = [
		'externe' => 'bool',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'externe',
		'inscription_id'
	];

	public function cr_courrier_entrants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierEntrant::class, 'provenance');
	}
}
