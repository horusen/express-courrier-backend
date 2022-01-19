<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Ged;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

/**
 * Class Fichier
 *
 * @property int $id
 * @property int $type
 * @property string $libelle
 * @property string $fichier
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\FichierType $fichier_type
 * @property \Illuminate\Database\Eloquent\Collection $cr_fichiers
 *
 * @package App\Models
 */
class Fichier extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'fichier';

	protected $casts = [
		'type' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'type',
		'libelle',
		'fichier',
		'inscription_id'
	];

    protected $classified = ['fichier'];

    /**
     * If the current user cannot read or write classified attributes then hide them
     */
    public function setClassifiedVisibility($permitted = false)
    {
        if ((!$this->ged_element->attributes['bloquer']) || Auth::check() && $this->attributes['inscription_id'] === 1) {
            $permitted = true;
        }
        if (!$permitted) $this->setHidden($this->classified);
    }

     //Make it available in the json response
	protected $appends = ['size', 'is_user'];

    //implement the attribute
	public function getSizeAttribute()
	{
        return Storage::disk('local')->size($this->attributes['fichier']);
        return filesize("http://127.0.0.1:8000/".$this->attributes['fichier']);
	}

    public function getIsUserAttribute()
	{
        return true;
		if(Auth::check() && $this->attributes['inscription_id'] === 1)
		{
			return true;
		}
		return false;
	}

    public function getFichierAttribute(){
		if($this->attributes['fichier']){
			$document_scanne = "http://127.0.0.1:8000/".$this->attributes['fichier'];
			return $document_scanne;
		}
		return 0;
	}


	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription_id');
	}

	public function fichier_type()
	{
		return $this->belongsTo(\App\Models\Ged\FichierType::class, 'type');
	}

	public function cr_fichiers()
	{
		return $this->hasMany(\App\Models\Courrier\CrFichier::class, 'fichier');
	}

    public function ged_element()
    {
        return $this->morphOne(Image::class, 'objet');
    }

    public function dossiers()
	{
		return $this->belongsToMany(\App\Models\Ged\Dossier::class, 'fichier_dossier', 'fichier_id', 'dossier_id');
	}

    public function dossier()
	{
		return $this->hasOneThrough(\App\Models\Ged\Dossier::class, 'fichier_dossier', 'fichier_id', 'dossier.id', 'fichier.id', 'dossier_id');
    }
}
