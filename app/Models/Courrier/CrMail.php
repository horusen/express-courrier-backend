<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 May 2022 12:02:03 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Support\Facades\Auth;
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
    protected $touches = ['cr_mail'];

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

    //Make it available in the json response
	protected $appends = ['auteur','reply_number','is_user_mail' ,'user_has_read', 'has_new_response', 'user_favoris'];

	//implement the attribute
	public function getAuteurAttribute()
	{
		return $this->inscription_personne()->first(['nom','prenom', 'email', 'photo', 'id']);
	}

    public function getIsUserMailAttribute()
	{
		if(Auth::check() && $this->attributes['inscription'] == Auth::id())
		{
			return true;
		}
		return false;
	}

    public function getReplyNumberAttribute()
	{
		return $this->cr_mails()->count();
	}

    public function getUserHasReadAttribute()
	{
		if(Auth::check())
		{
			return  $this->vues()->where('inscription.id', Auth::id())->count();
		}
		return false;
	}

    public function getHasNewResponseAttribute()
	{
		if(Auth::check())
		{
            return $this->cr_mails()->whereDoesntHave('vues', function ($query) {
                $query->where('inscription.id', Auth::id());
            })->count();
		}
		return false;
	}

    public function getUserFavorisAttribute()
	{
		if(Auth::check())
		{
			return $this->favoris()->where('inscription.id', Auth::id())->count();
		}
		return false;
    }

    protected $with = [
        'destinataire_personnes',
        'destinataire_structures',
        'fichiers',
        'tags'
    ];

	public function inscription_personne()
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

    public function destinataire_personnes()
	{
        return $this->belongsToMany(\App\Models\Inscription::class, 'cr_affectation_mail_personne', 'mail', 'personne');
	}

    public function destinataire_structures()
	{
        return $this->belongsToMany(\App\Models\Structure::class, 'cr_affectation_mail_structure', 'mail', 'structure');
	}

	public function cr_mails()
	{
		return $this->hasMany(\App\Models\Courrier\CrMail::class, 'mail');
	}

    public function fichiers()
	{
		return $this->belongsToMany(\App\Models\Ged\Fichier::class, 'cr_affectation_mail_fichier', 'mail', 'fichier');
	}

    public function tags()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrMailTag::class, 'cr_affectation_mail_tag', 'mail', 'tag');
	}

    public function vues()
	{
		return $this->belongsToMany(\App\Models\Inscription::class, 'cr_affectation_mail_vue', 'mail', 'personne');
	}

    public function favoris()
	{
		return $this->belongsToMany(\App\Models\Inscription::class, 'cr_affectation_mail_like', 'mail', 'personne');
    }

}
