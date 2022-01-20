<?php

namespace App\Models\Messagerie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeletedDiscussion extends Model
{
    use SoftDeletes;
    protected $table = 'deleted_discussions';
    protected $primaryKey = 'id';
    protected $fillable = ['discussion', 'inscription', 'user', 'structure'];
}
