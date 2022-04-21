<?php

namespace App\Models\Messagerie;

use App\ApiRequest\ApiRequestConsumer;
use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Discussion extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'discussions';
    protected $fillable = ['inscription', 'type', 'touched_at'];
    protected $appends = ['derniere_reaction', 'correspondance', 'nombre_reaction_non_lus'];




    /**
     *
     * Relationships
     *
     */

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'discussion')->whereNotDeleted();
    }

    public function type()
    {
        return $this->belongsTo(TypeDiscussion::class, 'type');
    }

    public function correspondance_personne()
    {
        return $this->hasOne(CorrespondancePersonne::class, 'discussion')->select(['user1', 'user2']);
    }





    public function correspondance_personne_structure()
    {
        return $this->hasOne(CorrespondancePersonneStructure::class, 'discussion')->select(['user', 'structure']);
    }

    public function deletions()
    {
        return $this->hasMany(DeletedDiscussion::class, 'discussion');
    }




    /**
     *
     * ATTRIBUTES
     *
     *
     */
    public function getDerniereReactionAttribute()
    {
        return $this->reactions()->latest()->first();
    }

    public function getCorrespondanceAttribute()
    {
        if ($this->type == 1) {
            return $this->correspondance_personne()->get()->first();
        } else if ($this->type == 2) {
            return $this->correspondance_personne_structure()->get()->first();
        }
    }

    public function getNombreReactionNonLusAttribute()
    {
        return $this->reactions()->whereNotReaded(Auth::id())->count();
    }




    /**
     *
     * SCOPES
     *
     */
    public function scopeWhereCorrespondant(Builder $query, $user)
    {
        return $query->whereHas('correspondance_personne', function (Builder $q) use ($user) {
            $q->where('user1', $user)->orWhere('user2', $user);
        })->orWhereHas('correspondance_personne_structure', function (Builder $q) use ($user) {
            $q->where('user', $user);
        });
    }

    public function scopeWhereStructure(Builder $query, $structure)
    {
        return  $query->whereHas('correspondance_personne_structure', function (Builder $q) use ($structure) {
            $q->where('structure', $structure);
        });
    }


    public function scopeWhereReaction(Builder $query)
    {
        return $query->whereHas('reactions', function ($q) {
            $q->whereDoesntHave('deletions', function ($q) {
                $q->where('user', Auth::id());
            });
        });
    }

    public function scopeWhereCorrespondants(Builder $query, $user1, $user2)
    {
        return $query->whereHas('correspondance_personne', function (Builder $query) use ($user1, $user2) {
            $query->where(function ($q) use ($user1, $user2) {
                $q->where('user1', $user1)->where('user2', $user2);
            })->orWhere(function ($q) use ($user1, $user2) {
                $q->where('user2', $user1)->where('user1', $user2);
            });
        });
    }


    public function scopeWhereCorrespondantStructure(Builder $query, $user, $structure)
    {
        return $query->whereHas('correspondance_personne_structure', function (Builder $query) use ($user, $structure) {
            $query->where('user', $user)->where('structure', $structure);
        });
    }


    public function scopeWhereNotDeleted(Builder $query, $user)
    {
        return $query->whereDoesntHave('deletions', function ($q) use ($user) {
            $q->where('created_at', '<', 'discussions.touched_at')->where('user', $user);
        });
    }

    public function scopeWhereNotDeletedStructure(Builder $query, $structure)
    {
        return $query->whereDoesntHave('deletions', function ($q) use ($structure) {
            $q->where('created_at', '<', 'discussions.touched_at')->where('structure', $structure);
        });
    }
}
