<?php

namespace App;

use App\ApiRequest\ApiRequestConsumer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use SoftDeletes, ApiRequestConsumer;
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'message', 'element', 'element_id', 'inscription', 'user', 'link'
    ];
}
