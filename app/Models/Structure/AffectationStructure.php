<?php

namespace App\Models\Structure;

use App\ApiRequest\ApiRequestConsumer;
use App\Models\Authorization\Authorisation;
use App\Models\Authorization\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationStructure extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'affectation_structures';
    protected $fillable = [
        'user', 'structure', 'fonction', 'poste', 'inscription', 'activated_at', 'role'
    ];

    protected $appends = ['status'];

    public function user()
    {
        return $this->belongsTo(Inscription::class, 'user');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class, 'structure');
    }

    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'fonction');
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role');
    }


    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste');
    }

    public function droit()
    {
        return $this->belongsTo(DroitAcces::class, 'droit_acces');
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }


    /**
     * Permet de savoir le status de l'utilisateur
     * Ce status est soit:
     *  *   'unactivated' si le user a validé son mail mais qu'il a pas été validé par l admin
     *  *   'unverified' si le user a été validé par l'admin mais quíl n'a pas encore validé son mail
     *  *   'invalid' si le user n'a ni été validé par l'admin, ni validé son mail
     *  *   'valid' si le user a validé son mail et est validé par l'admin
     */

    public function getStatusAttribute()
    {
        if ($this->user()->first()->email_verified_at && !$this->activated_at) {
            return  'unactivated';
        } else if (!$this->user()->first()->email_verified_at && $this->activated_at) {
            return 'unverified';
        } else if (!$this->user()->first()->email_verified_at && !$this->activated_at) {
            return 'invalid';
        }


        return 'valid';
    }


    public function scopeStatus(Builder $query, $status)
    {

        if ($status == 'valid') {
            return $query->whereNotNull('activated_at')->whereHas('user', function ($q) {
                $q->whereNotNull('email_verified_at');
            });
        } else if ($status == 'unactivated') {
            return $query->whereNull('activated_at');
        } else if ($status == 'unverified') {
            return $query->whereHas('user', function ($q) {
                $q->whereNull('email_verified_at');
            });
        }


        return $query;
    }
}
