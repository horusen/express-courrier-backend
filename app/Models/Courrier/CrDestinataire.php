<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrDestinataire
 *
 * @property int $id
 * @property int $coordonnee_id
 * @property int $inscription_id
 * @property int $courrier_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Courrier\CrCoordonnee $cr_coordonnee
 * @property \App\Models\Courrier\CrCourrierSortant $cr_courrier_sortant
 * @property \App\Models\Inscription $inscription
 *
 * @package App\Models
 */
class CrDestinataire extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_destinataire';

	protected $casts = [
		'coordonnee_id' => 'int',
		'inscription_id' => 'int',
		'courrier_id' => 'int'
	];

	protected $fillable = [
		'coordonnee_id',
		'inscription_id',
		'courrier_id'
	];

    protected $with = [
        'cr_coordonnee'
    ];

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'coordonnee_id');
	}

	public function cr_courrier_sortant()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrierSortant::class, 'courrier_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}
}
