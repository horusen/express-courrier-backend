<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConditionsUtilisation extends Model
{
    use SoftDeletes;
    protected $table = 'conditions_utilisations';
    protected $primaryKey = 'id';
    protected $fillable = ['conditions_utilisations', 'inscription'];
}
