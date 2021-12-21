<?php

namespace App\Models\Structure;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;
    protected $table = 'admins';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function type()
    {
        return $this->belongsTo(TypeAdmin::class, 'type');
    }

    public function service()
    {
        return $this->belongsTo(Structure::class, 'structure');
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription');
    }
}
