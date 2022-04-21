<?php

namespace App\Models\Evenement;

use Illuminate\Database\Eloquent\Model;

class Commentevenement extends Model
{
    protected $table = 'cr_comment_evenement';
    protected $guarded = ['id'];

     
     public function evenement()
    {
        return $this->hasOne('App\Models\Evenement\Evenement','id','evenement');
    } 

     public function inscription() 
    {
        return $this->hasOne('App\Models\Inscription','id','inscription');
    }
}
