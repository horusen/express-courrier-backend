<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrStructureCopie
 *
 * @property int $id
 * @property bool $info
 * @property bool $traitement
 * @property int $structure
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @package App\Models
 */
class CrStructureCopie extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_structure_copie';

	protected $casts = [
		'info' => 'bool',
		'traitement' => 'bool',
		'structure' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'info',
		'traitement',
		'structure',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure');
	}
}
