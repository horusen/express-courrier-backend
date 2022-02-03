<?php

namespace App\Models\Messagerie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReactionSupprime extends Model
{
    use SoftDeletes;
    protected $table = 'reaction_supprimes';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'user', 'structure'];
}
