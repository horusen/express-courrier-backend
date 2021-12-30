<?php

namespace App\Models\Messagerie;

use App\Models\Structure\Inscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;
    protected $table = 'discussions';
    protected $fillable = ['inscription'];


    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
