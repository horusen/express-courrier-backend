<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 May 2022 12:02:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrMail
 *
 * @property int $id
 * @property string $libelle
 * @property string $contenu
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $mail
 * @property bool $draft
 *
 * @property \App\Models\CrMail $cr_mail
 * @property \Illuminate\Database\Eloquent\Collection $cr_affectation_mail_personnes
 * @property \Illuminate\Database\Eloquent\Collection $cr_mails
 *
 * @package App\Models
 */
class CrMail extends Eloquent
{
	protected $table = 'cr_mail';

	protected $casts = [
		'inscription' => 'int',
		'mail' => 'int',
		'draft' => 'bool'
	];

	protected $fillable = [
		'libelle',
		'contenu',
		'inscription',
		'mail',
		'draft'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function cr_mail()
	{
		return $this->belongsTo(\App\Models\Courrier\CrMail::class, 'mail');
	}

	public function cr_affectation_mail_personnes()
	{
		return $this->hasMany(\App\Models\CrAffectationMailPersonne::class, 'mail');
	}

    public function destinataires()
	{
        return $this->belongsToMany(\App\Models\Inscription::class, 'cr_affectation_mail_personnes', 'mail', 'personne');
	}

	public function cr_mails()
	{
		return $this->hasMany(\App\Models\Courrier\CrMail::class, 'mail');
	}
}
