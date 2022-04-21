<?php

namespace App\Models\Evenement;

use Illuminate\Database\Eloquent\Model;

class Sharedevenement extends Model
{
    
    protected $table = 'cr_shared_evenement';
    protected $guarded = ['id'];

     
     public function evenement()
    {
        return $this->hasOne('App\Models\Evenement\Evenement','id','evenement');
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
