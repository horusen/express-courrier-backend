<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;
    protected $table = 'discussions';
    protected $fillable = ['inscription'];
    protected $with = ['intervenants'];
    protected $appends = ['derniere_reaction'];


    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function intervenants()
    {
        return $this->hasOne(IntervenantDiscussion::class, 'discussion');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'discussion');
    }


    public function getDerniereReactionAttribute()
    {
        return $this->reactions()->latest()->first();
    }
}
