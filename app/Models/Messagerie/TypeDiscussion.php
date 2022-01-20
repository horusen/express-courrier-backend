<?php

namespace App\Models\Messagerie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeDiscussion extends Model
{
    use SoftDeletes;
    protected $table = 'type_discussions';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'inscription', 'description'];
}
