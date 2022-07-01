<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpAffectationEtapeTypeProcedure
 *
 * @property int $id_pivot
 * @property int $etape
 * @property int $type
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\MpEtape $mp_etape
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\MpTypeProcedure $mp_type_procedure
 *
 * @package App\Models
 */
class MpAffectationEtapeTypeProcedure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_affectation_etape_type_procedure';
	protected $primaryKey = 'id_pivot';

	protected $casts = [
		'etape' => 'int',
		'type' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'etape',
		'type',
		'inscription_id'
	];

	public function mp_etape()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpEtape::class, 'etape');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_type_procedure()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpTypeProcedure::class, 'type');
	}
}
