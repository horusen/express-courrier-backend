<?php

namespace App\Models\Tableauobjectif;

use Illuminate\Database\Eloquent\Model;

class Tableauobjectif extends Model
{
    protected $table = 'cr_tableau_objectif';
    protected $guarded = ['id'];

   
     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
