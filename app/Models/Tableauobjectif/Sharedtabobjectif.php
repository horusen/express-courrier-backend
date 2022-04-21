<?php

namespace App\Models\Tableauobjectif;

use Illuminate\Database\Eloquent\Model;

class Sharedtabobjectif extends Model
{
    protected $table = 'cr_tableau_objectif_shared';
    protected $guarded = ['id'];

     
     public function objectif()
    {
        return $this->hasOne('App\Models\Tableauobjectif\Tableauobjectif','id','objectif');
    } 

     public function receveur() 
    {
        return $this->hasOne('App\Models\Inscription','id','receveur');
    }

     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
