<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Authorization;

use App\ApiRequest\ApiRequestConsumer;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Inscription;
use App\Models\Structure\Structure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id
 * @property string $libelle
 * @property string|null $description
 * @property int $inscription
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Role extends Model
{
    use ApiRequestConsumer, \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'roles';

    protected $casts = [
        'inscription' => 'int'
    ];

    protected $fillable = [
        'libelle',
        'structure',
        'description',
        'inscription'
    ];

    protected $with = [];

    protected $appends = ['nombre_utilisateurs'];

    protected $hidden = ['users'];

    public function users()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'role', 'user');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class, 'structure');
    }

    public function affectation_structures()
    {
        return $this->hasMany(AffectationStructure::class, 'role');
    }

    public function getNombreUtilisateursAttribute()
    {
        return $this->users->count();
    }

    public function authorisations()
    {
        return $this->hasMany(Authorisation::class, 'role');
    }
}
