<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Jun 2022 11:45:43 +0000.
 */

namespace App\Models\MarchePublic;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MpMarche
 *
 * @property int $id
 * @property string $libelle
 * @property \Carbon\Carbon $date_execution
 * @property \Carbon\Carbon $date_fermeture
 * @property int $service_contractant_id
 * @property int $type_procedure_id
 * @property int $type_marche_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Structure $structure
 * @property \App\Models\MpTypeMarche $mp_type_marche
 * @property \App\Models\MpTypeProcedure $mp_type_procedure
 * @property \Illuminate\Database\Eloquent\Collection $mp_marche_etapes
 *
 * @package App\Models
 */
class MpMarche extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'mp_marche';

	protected $casts = [
		'service_contractant_id' => 'int',
		'type_procedure_id' => 'int',
		'type_marche_id' => 'int',
		'fournisseur_id',
		'cout' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_execution',
		'date_fermeture'
	];

	protected $fillable = [
		'libelle',
		'date_execution',
		'date_fermeture',
		'service_contractant_id',
		'type_procedure_id',
		'type_marche_id',
		'fournisseur_id',
		'cout',
		'source_financement',
		'inscription_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'service_contractant_id');
	}

    public function fournisseur()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'fournisseur_id');
	}

	public function mp_type_marche()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpTypeMarche::class, 'type_marche_id');
	}

	public function mp_type_procedure()
	{
		return $this->belongsTo(\App\Models\MarchePublic\MpTypeProcedure::class, 'type_procedure_id');
	}

	public function mp_marche_etapes()
	{
		return $this->hasMany(\App\Models\MarchePublic\MpMarcheEtape::class, 'marche_id')->orderBy('position', 'asc');
	}

    public function fournisseurs()
    {
        return $this->belongsToMany(\App\Models\Courrier\CrCoordonnee::class, 'mp_affectation_marche_fournisseur', 'marche', 'coordonnee');
    }

    public function partenaires()
    {
        return $this->belongsToMany(\App\Models\Courrier\CrCoordonnee::class, 'mp_affectation_marche_partenaire', 'marche', 'coordonnee');
    }
}
