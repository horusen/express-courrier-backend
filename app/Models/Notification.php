<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 May 2022 11:56:44 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Notification
 *
 * @property int $id
 * @property string $element
 * @property int $element_id
 * @property string $message
 * @property int $user
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @package App\Models
 */
class Notification extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'element_id' => 'int',
		'user' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'element',
		'element_id',
		'message',
		'user',
		'inscription',
        'link'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'user');
	}
}
