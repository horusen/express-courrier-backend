<?php

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model;

class CrStatut extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'cr_statut';

    protected $casts = [
        'inscription_id' => 'int'
    ];

    protected $fillable = [
        'libelle',
        'inscription_id'
    ];

    public function inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class);
    }

    public function cr_courriers()
    {
        return $this->hasMany(\App\Models\Courrier\CrCourrier::class, 'statut_id');
    }

}
