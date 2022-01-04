<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{
    use SoftDeletes;
    protected $table = 'inscription';
    protected $guarded = [];
    protected $appends = ['nom_complet'];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function structures()
    {
        return $this->belongsToMany(Structure::class, AffectationStructure::class, 'user', 'structure');
    }


    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }


    public function isResponsableStructure()
    {
        return $this->belongsToMany(Structure::class, ResponsableStructure::class, 'responsable', 'structure');
    }
}
