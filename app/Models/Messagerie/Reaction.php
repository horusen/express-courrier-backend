<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use SoftDeletes;
    protected $table = 'reactions';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'fichier', 'rebondissement', 'discussion', 'inscription'];
    protected $with = ['inscription'];


    public function rebondissement()
    {
        return $this->belongsTo(Reaction::class, 'rebondissement');
    }


    public function fichier()
    {
        return $this->belongsTo(Fichier::class, 'fichier');
    }


    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }


    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion');
    }
}
