<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Jan 2022 10:11:39 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrEtape
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property int $duree
 * @property int $etape
 * @property int $type_id
 * @property int $responsable_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Courrier\CrStatut $cr_statut
 * @property \App\Models\Courrier\CrType $cr_type
 * @property \App\Models\Structure $structure
 *
 * @package App\Models\Courrier
 */
class CrTache extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_tache';

	protected $casts = [
		'inscription_id' => 'int',
	];

    protected $dates = [
        'date_limit',
    ];

	protected $fillable = [
		'libelle',
		'description',
		'inscription_id',
        'statut_color',
        'statut_icon',
        'statut',
        'date_limit'
	];

    public function getCommentsCountAttribute()
	{
		return $this->cr_commentaires()->count();
    }

    protected $appends = ['comments_count'];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

    public function responsables()
	{
        return $this->belongsToMany(\App\Models\Inscription::class, 'cr_affectation_tache_personne', 'tache', 'personne');
	}

	public function courriers()
	{
        return $this->belongsToMany(\App\Models\Dash\CrCourrier::class, 'cr_affectation_tache_courrier', 'tache', 'courrier');
    }

    public function structures()
	{
        return $this->belongsToMany(\App\Models\Structure::class, 'cr_affectation_tache_structure', 'tache', 'structure');
    }

    public function cr_commentaires()
	{
		return $this->belongsToMany(\App\Models\Courrier\CrCommentaire::class, 'cr_affectation_commentaire_tache', 'tache', 'commentaire');
	}
}
