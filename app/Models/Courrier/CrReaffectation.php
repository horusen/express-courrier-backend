<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrReaffectation
 *
 * @property int $id
 * @property string $libelle
 * @property int $courrier_id
 * @property int $structure_id
 * @property int $suivi_par
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Courrier\CrCourrier $cr_courrier
 * @property \App\Models\Inscription $inscription
 * @property \App\Models\Structure $structure
 *
 * @package App\Models
 */
class CrReaffectation extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'cr_reaffectation';

    protected $casts = [
        'courrier_id' => 'int',
        'structure_id' => 'int',
        'suivi_par' => 'int',
        'inscription_id' => 'int'
    ];

    protected $fillable = [
        'libelle',
        'courrier_id',
        'structure_id',
        'suivi_par',
        'inscription_id'
    ];

    public function cr_courrier()
    {
        return $this->belongsTo(\App\Models\Courrier\CrCourrier::class, 'courrier_id');
    }

    public function inscription()
    {
        return $this->belongsTo(\App\Models\Inscription::class, 'suivi_par');
    }

    public function structure()
    {
        return $this->belongsTo(\App\Models\Structure::class);
    }

    public function suivi_par()
    {
        return $this->belongsTo(Inscription::class, 'suivi_par');
    }
}
