<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondancePersonne extends Model
{
    use SoftDeletes;
    protected $table = 'correspondance_personnes';
    protected $primaryKey = 'id';
    protected $fillable = ['user1', 'inscription', 'user2', 'discussion'];
    protected $with = [
        'user1:id,prenom,nom,photo',
        'user1.affectation_structure.structure:id,libelle,type',
        'user1.affectation_structure.poste:id,libelle',
        'user1.affectation_structure.fonction:id,libelle',
        'user2:id,prenom,nom,photo',
        'user2.affectation_structure.poste:id,libelle',
        'user2.affectation_structure.fonction:id,libelle',
        'user2.affectation_structure.structure:id,libelle,type'
    ];


    public function user1()
    {
        return $this->belongsTo(Inscription::class, 'user1')->select();
    }


    public function user2()
    {
        return $this->belongsTo(Inscription::class, 'user2');
    }
}
