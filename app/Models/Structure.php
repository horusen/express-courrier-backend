<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Structure
 * 
 * @property int $id
 * @property string $libelle
 * @property string $cigle
 * @property string $description
 * @property int $type
 * @property int $parent
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Structure $structure
 * @property \App\Models\TypeStructure $type_structure
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $affectation_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_autorisation_personne_structures
 * @property \Illuminate\Database\Eloquent\Collection $cr_courriers
 * @property \Illuminate\Database\Eloquent\Collection $cr_reaffectations
 * @property \Illuminate\Database\Eloquent\Collection $cr_structure_copies
 * @property \Illuminate\Database\Eloquent\Collection $ged_elements
 * @property \Illuminate\Database\Eloquent\Collection $structures
 *
 * @package App\Models
 */
class Structure extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'type' => 'int',
		'parent' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'cigle',
		'description',
		'type',
		'parent',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'parent');
	}

	public function type_structure()
	{
		return $this->belongsTo(\App\Models\TypeStructure::class, 'type');
	}

	public function admins()
	{
		return $this->hasMany(\App\Models\Admin::class, 'structure');
	}

	public function affectation_structures()
	{
		return $this->hasMany(\App\Models\AffectationStructure::class, 'structure');
	}

	public function cr_autorisation_personne_structures()
	{
		return $this->hasMany(\App\Models\CrAutorisationPersonneStructure::class, 'structure');
	}

	public function cr_courriers()
	{
		return $this->hasMany(\App\Models\CrCourrier::class, 'structure');
	}

	public function cr_reaffectations()
	{
		return $this->hasMany(\App\Models\CrReaffectation::class, 'structure');
	}

	public function cr_structure_copies()
	{
		return $this->hasMany(\App\Models\CrStructureCopie::class, 'structure');
	}

	public function ged_elements()
	{
		return $this->belongsToMany(\App\Models\GedElement::class, 'ged_element_structure', 'structure', 'element')
					->withPivot('id', 'inscription', 'deleted_at')
					->withTimestamps();
	}

	public function structures()
	{
		return $this->hasMany(\App\Models\Structure::class, 'parent');
	}
}
