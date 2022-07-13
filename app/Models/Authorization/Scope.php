<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Authorization;

use App\ApiRequest\ApiRequestConsumer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Scope
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
class Scope extends Model
{
    use ApiRequestConsumer;
    protected $table = 'scopes';

    protected $casts = [
        'inscription' => 'int'
    ];

    protected $fillable = [
        'libelle',
        'ensemble',
        'description',
        'inscription'
    ];
}
