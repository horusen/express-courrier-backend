<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DroitAcces extends Model
{
    use SoftDeletes;
    protected $table = 'droit_acces';
    protected $guarded = [];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
