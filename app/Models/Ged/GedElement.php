<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GedElement
 *
 * @property int $id
 * @property bool $actif
 * @property bool $cacher
 * @property bool $bloquer
 * @property string $password
 * @property string $objet_type
 * @property int $objet_id
 * @property \Carbon\Carbon $archivated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $ged_element_personnes
 * @property \Illuminate\Database\Eloquent\Collection $structures
 * @property \Illuminate\Database\Eloquent\Collection $ged_favoris
 * @property \Illuminate\Database\Eloquent\Collection $ged_partages
 *
 * @package App\Models
 */
class GedElement extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'ged_element';

	protected $casts = [
		'actif' => 'bool',
		'cacher' => 'bool',
		'bloquer' => 'bool',
		'objet_id' => 'int'
	];

	protected $dates = [
		'archivated_at'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'actif',
		'cacher',
		'bloquer',
		'password',
		'objet_type',
		'objet_id',
		'archivated_at'
	];

	public function ged_element_personnes()
	{
		return $this->hasMany(\App\Models\Ged\GedElementPersonne::class, 'element');
	}

	public function structures()
	{
		return $this->belongsToMany(\App\Models\Structure::class, 'ged_element_structure', 'element', 'structure')
					->withPivot('id', 'inscription', 'deleted_at')
					->withTimestamps();
	}

	public function ged_favoris()
	{
		return $this->hasMany(\App\Models\Ged\GedFavori::class, 'element');
	}

	public function ged_partages()
	{
		return $this->hasMany(\App\Models\Ged\GedPartage::class, 'element');
	}
}
