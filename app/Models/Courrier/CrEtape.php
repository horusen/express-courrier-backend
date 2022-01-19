<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Jan 2022 10:11:39 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $etape
 * @property int $type_id
 * @property int $responsable_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 *
 * @package App\Models
 */
class CrEtape extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_etape';

	protected $casts = [
		'etape' => 'int',
		'type_id' => 'int',
		'statut_id' => 'int',
		'responsable_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'etape',
		'type_id',
		'responsable_id',
		'statut_id',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

    public function responsable()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable_id');
	}

    public function cr_statut()
	{
		return $this->belongsTo(\App\Models\Courrier\CrStatut::class, 'statut_id');
	}

    public function cr_type()
	{
		return $this->belongsTo(\App\Models\Courrier\CrType::class, 'type_id');
	}
}
