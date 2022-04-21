<?php

namespace App\Models\Structure;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeStructure extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'type_structures';
    protected $guarded = [];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
