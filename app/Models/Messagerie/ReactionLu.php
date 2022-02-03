<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use App\Models\Structure\Structure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReactionLu extends Model
{
    use SoftDeletes;
    protected $table = 'reaction_lus';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'user', 'structure'];
    protected $with = ['user:id,nom,prenom', 'structure:id,libelle'];


    public function structure()
    {
        return $this->belongsTo(Structure::class, 'structure');
    }


    public function user()
    {
        return $this->belongsTo(Inscription::class, 'user');
    }
}
