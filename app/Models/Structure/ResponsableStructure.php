<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsableStructure extends Model
{
    use SoftDeletes;
    protected $table = 'responsable_structures';
    protected $primaryKey = 'id';
    protected $fillable = ['structure', 'inscription', 'responsable'];
}
