<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrCourrierEntrant
 *
 * @property int $id
 * @property \Carbon\Carbon $date_arrive
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $courrier_id
 * @property int $expediteur_id
 * @property int $responsable_id
 * @property int $inscription_id
 *
 * @property \App\Models\Courrier\CrCourrier $cr_courrier
 * @property \App\Models\Courrier\CrCoordonnee $cr_coordonnee
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_courrier_sortants
 * @property \Illuminate\Database\Eloquent\Collection $cr_structure_copies
 *
 * @package App\Models
 */
class CrCourrierEntrant extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_courrier_entrant';

	protected $casts = [
		'courrier_id' => 'int',
		'expediteur_id' => 'int',
		'responsable_id' => 'int',
        'expediteur_interne_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $dates = [
		'date_arrive'
	];

	protected $fillable = [
		'date_arrive',
		'courrier_id',
		'expediteur_id',
		'expediteur_type',
		'responsable_id',
		'inscription_id',
        'provenance'
	];

    protected $appends = ['expediteur_externe','expediteur_interne'];

    public function getExpediteurExterneAttribute(){
		if($this->attributes['expediteur_type']=='App\Models\Courrier\CrCoordonnee'){
			return $this->expediteur;
		}
		return null;
	}

    public function getExpediteurInterneAttribute(){
		if($this->attributes['expediteur_type']=='App\Models\Structure'){
			return $this->expediteur;
		}
		return null;
	}

    public function expediteur()
    {
        return $this->morphTo();
    }

    public function cr_provenance()
	{
		return $this->belongsTo(\App\Models\Courrier\CrProvenance::class, 'provenance');
	}

	public function cr_courrier()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
	}

	public function cr_coordonnee()
	{
		return $this->belongsTo(\App\Models\Courrier\CrCoordonnee::class, 'expediteur_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'responsable_id');
	}

    public function user()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

	public function cr_courrier_sortants()
	{
		return $this->hasMany(\App\Models\Courrier\CrCourrierSortant::class, 'courrier_entrant_id');
	}

	public function cr_structure_copies()
	{
		return $this->hasMany(\App\Models\Courrier\CrStructureCopie::class, 'courrier_id');
	}
}
