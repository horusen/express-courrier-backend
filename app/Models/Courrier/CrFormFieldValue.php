<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrFormFieldValue
 * 
 * @property int $id
 * @property string $value
 * @property string $objet_type
 * @property int $objet_id
 * @property int $form_field_id
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Courrier\CrFormField $cr_form_field
 * @property \App\Models\Inscription $inscription
 *
 * @package App\Models
 */
class CrFormFieldValue extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_form_field_value';

	protected $casts = [
		'objet_id' => 'int',
		'form_field_id' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'value',
		'objet_type',
		'objet_id',
		'form_field_id',
		'inscription_id'
	];

	public function cr_form_field()
	{
		return $this->belongsTo(\App\Models\Courrier\CrFormField::class, 'form_field_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}
}
