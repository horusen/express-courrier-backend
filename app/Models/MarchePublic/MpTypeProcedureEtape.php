<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpTypeProcedureEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $position
 * @property int $type_procedure_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\MpTypeProcedure $mp_type_procedure
 *
 * @package App\Models
 */
class MpTypeProcedureEtape extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_type_procedure_etape';

	protected $casts = [
		'position' => 'int',
		'type_procedure_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'position',
		'type_procedure_id',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_type_procedure()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpTypeProcedure::class, 'type_procedure_id');
	}
}
