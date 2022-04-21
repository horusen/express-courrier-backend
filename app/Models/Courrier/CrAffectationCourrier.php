<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Apr 2022 10:47:38 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrAffectationCourrier
 *
 * @property int $id
 * @property int $courrier
 * @property string $objet_type
 * @property int $objet_id
 * @property string $suggestion_reponse
 * @property string $recommandation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $inscription_id
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\CrCourrier $cr_courrier
 *
 * @package App\Models\Courrier
 */
class CrAffectationCourrier extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_affectation_courrier';

	protected $casts = [
		'courrier' => 'int',
		'objet_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'courrier',
		'objet_type',
		'objet_id',
		'suggestion_reponse',
		'recommandation',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier');
	}

    public function objet()
    {
        return $this->morphTo();
    }
}
