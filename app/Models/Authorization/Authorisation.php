<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Authorization;

use App\ApiRequest\ApiRequestConsumer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Authorisation
 *
 * @property int $id
 * @property int $role
 * @property int $inscription
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Authorisation extends Model
{
    use ApiRequestConsumer;
    protected $table = 'authorisations';

    // protected $casts = [
    //     'role' => 'int',
    //     // 'scope' => 'int',
    //     'inscription' => 'int'
    // ];

    protected $hidden = ['role1'];

    protected $fillable = [
        'role',
        'scope',
        'authorisation',
        'inscription'
    ];


    protected $appends = ['scope_name'];


    // protected $with = ['scope'];

    // protected $hidden = ['scope'];

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope');
    }

    public function role1()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    public function getScopeNameAttribute()
    {
        return $this->scope()->get()->first()->libelle;
    }

    public function getStructureAttribute()
    {
        $affectation_structure = $this->role1->affectation_structures()->where('user', Auth::id())->get()->first();
        return isset($affectation_structure) ? $affectation_structure->structure : null;
    }
}
