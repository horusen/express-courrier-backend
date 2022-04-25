<?php

namespace App\Models\Structure;

use App\Notifications\ValidationInscription;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Inscription extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, \Laravel\Sanctum\HasApiTokens;
    protected $table = 'inscription';
    protected $fillable = [
        'prenom', 'nom', 'date_naissance', 'lieu_naissance',
        'identifiant', 'telephone', 'photo', 'sexe',
        'inscription', 'email', 'email_verified_at', 'password'
    ];
    protected $appends = ['nom_complet'];
    protected $hidden = ['password'];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    // protected function getPhotoAttribute($value)
    // {
    //     return env('IMAGE_PREFIX_URL') . '/storage/' . $value;
    // }

    public function getPhotoAttribute()
    {
        if ($this->attributes['photo']) {
            $document_scanne = "http://localhost:8000/storage/" . $this->attributes['photo'];
            return $document_scanne;
        }
        return 0;
    }
    public function estDansStructures()
    {
        return $this->belongsToMany(Structure::class, AffectationStructure::class, 'user', 'structure');
    }

    public function structures()
    {
        return $this->hasMany(Structure::class, 'inscription');
    }

    public function affectation_structure()
    {
        return $this->hasOne(AffectationStructure::class, 'user');
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




    public function sendEmailVerificationNotification()
    {
        $this->notify(new ValidationInscription($this->inscription()->first()));
    }
}
