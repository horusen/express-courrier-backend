<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Apr 2022 10:47:38 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCommentaire
 *
 * @property int $id
 * @property string $libelle_commentaire
 * @property string $contenu
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $commentaire
 *
 * @property \App\Models\CrCommentaire $cr_commentaire
 * @property \Illuminate\Database\Eloquent\Collection $cr_commentaires
 *
 * @package App\Models\Courrier
 */
class CrCommentaire extends Eloquent
{
	protected $table = 'cr_commentaire';

	protected $casts = [
		'inscription' => 'int',
		'commentaire' => 'int'
	];

    protected $touches = ['cr_commentaire'];
    protected $with = ['cr_commentaires','fichiers'];

	protected $fillable = [
		'libelle_commentaire',
		'contenu',
		'inscription',
		'commentaire'
	];

    //Make it available in the json response
	protected $appends = ['auteur'];

    //implement the attribute
	public function getAuteurAttribute()
	{
		return $this->inscription()->first(['nom','prenom','photo']);
	}

	public function cr_commentaire()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCommentaire::class, 'commentaire');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function cr_commentaires()
	{
		return $this->hasMany(\App\Models\Courrier\CrCommentaire::class, 'commentaire');
	}

    public function fichiers()
	{
		return $this->belongsToMany(\App\Models\Ged\Fichier::class, 'cr_affectation_commentaire_fichier', 'commentaire', 'fichier');
	}

    public function ged_elements()
	{
		return $this->belongsToMany(\App\Models\Ged\GedElement::class, 'ged_affectation_commentaire_element', 'commentaire', 'element');
	}

    public function cr_courriers()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrCourrier::class, 'cr_affectation_commentaire_courrier', 'commentaire', 'courrier');
	}

    public function cr_taches()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrTache::class, 'cr_affectation_commentaire_tache', 'commentaire', 'tache');
	}
}
