<?php

namespace App\Models\Messagerie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReactionStructure extends Model
{
    use SoftDeletes;
    protected $table = 'reaction_structures';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'structure'];
}
