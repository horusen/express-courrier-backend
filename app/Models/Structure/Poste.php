<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poste extends Model
{
    use SoftDeletes;
    protected $table = 'postes';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description', 'inscription'];
}
