<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Inscription extends Authenticatable
{
    use SoftDeletes, Notifiable, \Laravel\Sanctum\HasApiTokens;
    protected $table = 'inscription';
    protected $guarded = [];
    protected $appends = ['nom_complet'];
    protected $hidden = ['password'];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function structures()
    {
        return $this->hasMany(Structure::class, 'inscription');
    }


    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function isResponsableStructure()
    {
        return $this->belongsToMany(Structure::class, ResponsableStructure::class, 'responsable', 'structure');
    }

    public function isEmployeStructures()
    {
        return $this->belongsToMany(Structure::class, AffectationStructure::class, 'user', 'structure');
    }
}
