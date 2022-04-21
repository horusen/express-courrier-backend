<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Apr 2022 10:47:38 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrierEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $duree
 * @property int $etape
 * @property int $responsable_id
 * @property int $inscription_id
 * @property int $structure_id
 * @property int $courrier_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\CrCourrier $cr_courrier
 * @property \App\Models\CrCourrierEtape $cr_courrier_etape
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Structure $structure
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_etapes
 *
 * @package App\Models
 */
class CrCourrierEtape extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_etape';

	protected $casts = [
		'duree' => 'int',
		'responsable_id' => 'int',
		'inscription_id' => 'int',
		'structure_id' => 'int',
		'courrier_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'description',
		'duree',
		'responsable_id',
		'inscription_id',
		'structure_id',
		'courrier_id',
        'statut_color',
        'statut_icon',
        'statut',
        'commentaire'
	];

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
	}

	public function cr_courrier_etape()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrierEtape::class, 'etape');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable_id');
	}

    public function responsable()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable_id');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class);
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrier::class, 'current_etape_id');
	}

	public function cr_courrier_etapes()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierEtape::class, 'etape');
	}
}
