<?php

namespace App\Models\Tableauobjectif;

use Illuminate\Database\Eloquent\Model;

class Commenttabobjectif extends Model
{
    protected $table = 'cr_tableau_objectif_comment';
    protected $guarded = ['id'];

      public function objectif()
    {
        return $this->hasOne('App\Models\Tableauobjectif\Tableauobjectif','id','objectif');
    } 
    
     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
