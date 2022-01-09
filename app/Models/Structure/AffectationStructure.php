<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationStructure extends Model
{
    use SoftDeletes;
    protected $table = 'affectation_structures';
    protected $fillable = [
        'user', 'structure', 'fonction', 'poste', 'droit_acces', 'inscription'
    ];


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
}
