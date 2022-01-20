<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;
    protected $table = 'discussions';
    protected $fillable = ['inscription', 'type', 'touched_at'];
    protected $appends = ['derniere_reaction'];


    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'discussion');
    }

    public function type()
    {
        return $this->belongsTo(TypeDiscussion::class, 'type');
    }

    public function correspondance_personne()
    {
        return $this->hasOne(CorrespondancePersonne::class, 'discussion');
    }


    public function correspondance_personne_structure()
    {
        return $this->hasOne(CorrespondancePersonneStructure::class, 'discussion');
    }

    public function getDerniereReactionAttribute()
    {
        return $this->reactions()->latest()->first();
    }
}
