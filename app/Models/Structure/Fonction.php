<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fonction extends Model
{
    use SoftDeletes;
    protected $table = 'fonction';
    protected $guarded = [];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
