<?php

namespace App\Models\Evenement;

use Illuminate\Database\Eloquent\Model;

class Participevenement extends Model
{
    protected $table = 'cr_participe_evenement';
    protected $guarded = ['id'];

     
     public function evenement()
    {
        return $this->hasOne('App\Models\Evenement\Evenement','id','evenement');
    } 

     public function participant() 
    {
        return $this->hasOne('App\Models\Inscription','id','participant');
    }

     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
