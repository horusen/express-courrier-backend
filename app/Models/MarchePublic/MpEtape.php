<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $mp_affectation_etape_type_procedures
 *
 * @package App\Models
 */
class MpEtape extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_etape';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_affectation_etape_type_procedures()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpAffectationEtapeTypeProcedure::class, 'etape');
	}

    public function mp_type_procedures()
    {
        return $this->belongsToMany(\App\Models\MarchePublic\MpTypeProcedure::class, 'mp_affectation_etape_type_procedure', 'etape', 'type');
    }

}
