<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrType
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
 * @property \App\Models\Courrier\CrType $cr_type
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_types
 *
 * @package App\Models
 */
class CrType extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_type';

	protected $casts = [
		'inscription_id' => 'int',
		'type_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'inscription_id',
		'type_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_type()
	{
		return $this->belongsTo(\App\Models\Courrier\CrType::class, 'type_id');
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrier::class, 'type_id');
	}


    public function cr_etapes()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrType::class, 'cr_affectation_etape_type_courrier', 'type', 'etape');
	}

    public function cr_etapes_clearing()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrType::class, 'cr_affectation_etape_type_courrier', 'type', 'etape');
	}

}
