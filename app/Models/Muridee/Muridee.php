<?php

namespace App\Models\Muridee;

use Illuminate\Database\Eloquent\Model;

class Muridee extends Model
{
    protected $table = 'cr_mur_idee';
    protected $guarded = ['id'];
  

     public function likes() 
    { 
        return $this->hasMany('App\Models\Muridee\Likemuridee','mur_idee');
    } 

   
     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
