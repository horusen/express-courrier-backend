<?php

namespace App\Models\Evenement;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'cr_evenement';
    protected $guarded = ['id'];

   
     public function participants() 
    { 
        return $this->hasMany('App\Models\Evenement\Participevenement','evenement');
    } 

    public function files()
    {
        return $this->hasMany('\App\Models\Evenement\Fileevenement','evenement');
    }
 
     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
