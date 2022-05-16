<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 May 2022 11:56:44 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrMailTag
 *
 * @property int $id
 * @property string $libelle
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_affectation_mail_tags
 *
 * @package App\Models
 */
class CrMailTag extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_mail_tag';

	protected $casts = [
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'libelle',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function cr_affectation_mail_tags()
	{
		return $this->hasMany(\App\Models\CrAffectationMailTag::class, 'tag');
	}

    public function mails()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrMail::class, 'cr_affectation_mail_tag', 'tag', 'mail');
	}
}
