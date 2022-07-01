<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpTypeProcedure
 *
 * @property int $id
 * @property string $libelle
 * @property int $inscription_id
 * @property int $type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\MpTypeProcedure $mp_type_procedure
 * @property \Illuminate\Database\Eloquent\Collection $mp_affectation_etape_type_procedures
 * @property \Illuminate\Database\Eloquent\Collection $mp_marches
 * @property \Illuminate\Database\Eloquent\Collection $mp_type_procedures
 *
 * @package App\Models
 */
class MpTypeProcedure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_type_procedure';

	protected $casts = [
		'inscription_id' => 'int',
		'type_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'inscription_id',
		'type_id'
	];

    protected $appends = ['cant_delete'];

	public function getCantDeleteAttribute()
	{

        return $this->mp_marches()->count() + $this->mp_type_procedures()->count();
	}


	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_type_procedure()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpTypeProcedure::class, 'type_id');
	}

	public function mp_affectation_etape_type_procedures()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpAffectationEtapeTypeProcedure::class, 'type');
	}

    public function mp_etapes()
    {
        return $this->belongsToMany(App\Models\MarchePublic\MpEtape::class, 'mp_affectation_etape_type_procedure', 'type', 'etape');
    }

	public function mp_marches()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpMarche::class, 'type_procedure_id');
	}

	public function mp_type_procedures()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpTypeProcedure::class, 'type_id');
	}

    public function mp_type_procedure_etapes()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpTypeProcedureEtape::class, 'type_procedure_id')->orderBy('position', 'asc');
	}
}
