<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpMarcheEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $position
 * @property int $marche_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\MpMarche $mp_marche
 *
 * @package App\Models
 */
class MpMarcheEtape extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_marche_etape';

	protected $casts = [
		'position' => 'int',
		'marche_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'position',
		'marche_id',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function mp_marche()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpMarche::class, 'marche_id');
	}

    public function fichiers()
	{
		return $this->belongsToMany(\App\Models\Ged\Fichier::class, 'mp_affectation_marche_fichier', 'marche', 'fichier');
	}
}

