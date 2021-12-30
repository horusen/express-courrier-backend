<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedFavori
 *
 * @property int $id
 * @property int $element
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\GedElement $ged_element
 *
 * @package App\Models
 */
class GedFavori extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_favori';

	protected $casts = [
		'element' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'element',
		'inscription_id'
	];

	public function ged_element()
	{
		return $this->belongsTo(\App\Models\Ged\GedElement::class, 'element');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}
}
