<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Authorization;

use App\ApiRequest\ApiRequestConsumer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    public function getScopeNameAttribute()
    {
        return $this->scope()->get()->first()->libelle;
    }
}
