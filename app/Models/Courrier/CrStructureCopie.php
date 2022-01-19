<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrStructureCopie
 * 
 * @property int $id
 * @property bool $info
 * @property bool $traitement
 * @property int $courrier_id
 * @property int $structure_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Courrier\CrCourrierEntrant $cr_courrier_entrant
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Structure $structure
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
		'courrier_id' => 'int',
		'structure_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'info',
		'traitement',
		'courrier_id',
		'structure_id',
		'inscription_id'
	];

	public function cr_courrier_entrant()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrierEntrant::class, 'courrier_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class);
	}
}
