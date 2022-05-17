<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCoordonnee
 *
 * @property int $id
 * @property string $libelle
 * @property string $email
 * @property string $telephone
 * @property string $adresse
 * @property string $condition_suivi
 * @property string $commentaire
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_ampiliations
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_entrants
 * @property \Illuminate\Database\Eloquent\Collection $cr_destinataires
 *
 * @package App\Models
 */
class CrCoordonnee extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_coordonnee';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'email',
		'telephone',
		'adresse',
		'condition_suivi',
		'commentaire',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_ampiliations()
	{
		return $this->hasMany(\App\Models\Courrier\CrAmpiliation::class, 'coordonnee_id');
	}

	public function cr_courrier_entrants()
	{
		return $this->hasMany(\App\Models\Dash\CrCourrierEntrant::class, 'expediteur_id');
	}

	public function cr_destinataires()
	{
		return $this->hasMany(\App\Models\Courrier\CrDestinataire::class, 'coordonnee_id');
	}
}
