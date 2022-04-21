<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use App\Models\Structure\Structure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondancePersonneStructure extends Model
{
    use SoftDeletes;
    protected $table = 'correspondance_personne_structures';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'inscription', 'structure', 'discussion'];


    public function structure()
    {
        return $this->belongsTo(Structure::class, 'structure');
    }


    public function user()
    {
        return $this->belongsTo(Inscription::class, 'user');
    }
}
