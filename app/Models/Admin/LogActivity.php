<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 28 Dec 2021 16:27:03 +0000.
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class LogActivity
 *
 * @property int $id
 * @property string $libelle
 * @property string $objet_type
 * @property int $objet_id
 * @property int $inscription
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @package App\Models
 */
class LogActivity extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'log_activity';

	protected $casts = [
		'objet_id' => 'int',
		'inscription' => 'int'
	];

	protected $fillable = [
		'libelle',
		'objet_type',
		'objet_id',
		'inscription'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class, 'inscription');
	}
}
