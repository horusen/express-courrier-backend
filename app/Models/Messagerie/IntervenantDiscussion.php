<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntervenantDiscussion extends Model
{
    use SoftDeletes;
    protected $table = 'intervenants_discussion';
    protected $primaryKey = 'id';
    protected $fillable = ['user1', 'user2', 'discussion', 'inscription'];


    public function user1()
    {
        return $this->belongsTo(Inscription::class, 'user1');
    }


    public function user2()
    {
        return $this->belongsTo(Inscription::class, 'user2');
    }


    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion');
    }


    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
