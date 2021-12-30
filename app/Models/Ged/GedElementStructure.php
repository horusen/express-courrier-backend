<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedElementStructure
 *
 * @property int $id
 * @property int $structure
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
class GedElementStructure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_element_structure';

	protected $casts = [
		'structure' => 'int',
		'element' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'structure',
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

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure');
	}
}
