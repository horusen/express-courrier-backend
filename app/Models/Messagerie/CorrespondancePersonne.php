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
    protected $with = ['user1:id,prenom,nom,photo', 'user2:id,prenom,nom,photo'];


    public function user1()
    {
        return $this->belongsTo(Inscription::class, 'user1')->select();
    }


    public function user2()
    {
        return $this->belongsTo(Inscription::class, 'user2');
    }
}
