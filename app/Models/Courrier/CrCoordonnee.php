<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Courrier;

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
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
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
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'email',
		'telephone',
		'adresse',
		'condition_suivi',
		'commentaire',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function cr_ampiliations()
	{
		return $this->hasMany(\App\Models\Courrier\CrAmpiliation::class, 'coordonnee');
	}

	public function cr_courrier_entrants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierEntrant::class, 'expediteur');
	}

	public function cr_destinataires()
	{
		return $this->hasMany(\App\Models\Courrier\CrDestinataire::class, 'coordonnee');
	}
}
