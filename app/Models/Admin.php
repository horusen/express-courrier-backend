<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Admin
 * 
 * @property int $id
 * @property int $user
 * @property int $type
 * @property int $structure
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\TypeAdmin $type_admin
 *
 * @package App\Models
 */
class Admin extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'user' => 'int',
		'type' => 'int',
		'structure' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'user',
		'type',
		'structure',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'user');
	}

	public function structure()
	{
		return $this->belongsTo(\App\Models\Structure::class, 'structure');
	}

	public function type_admin()
	{
		return $this->belongsTo(\App\Models\TypeAdmin::class, 'type');
	}
}
