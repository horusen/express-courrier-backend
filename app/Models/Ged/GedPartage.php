<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedPartage
 *
 * @property int $id
 * @property int $personne
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
class GedPartage extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_partage';

	protected $casts = [
		'personne' => 'int',
		'element' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'personne',
		'element',
		'inscription'
	];

	public function ged_element()
	{
		return $this->belongsTo(\App\Models\Ged\GedElement::class, 'element');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'personne');
	}
}
