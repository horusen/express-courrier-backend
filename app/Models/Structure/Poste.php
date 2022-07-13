<?php

namespace App\Models\Structure;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poste extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'postes';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description', 'inscription', 'structure'];


    public function users()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'poste', 'user');
    }


    public function getNombreUtilisateursAttribute()
    {
        return $this->users()->count();
    }
}
