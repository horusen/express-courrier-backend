<?php

namespace App\Models\Structure;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fonction extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'fonctions';
    protected $guarded = [];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }

    public function users()
    {
        return $this->belongsToMany(Inscription::class, AffectationStructure::class, 'fonction', 'user');
    }
}
