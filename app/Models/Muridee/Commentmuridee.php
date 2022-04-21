<?php

namespace App\Models\Muridee;

use Illuminate\Database\Eloquent\Model;

class Commentmuridee extends Model
{
    protected $table = 'cr_mur_idee_comment';
    protected $guarded = ['id'];

     
     public function mur_idee()
    {
        return $this->hasOne('App\Models\Muridee\Muridee','id','mur_idee');
    } 

     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
