<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrFormFieldValidator
 *
 * @property int $id
 * @property bool $required
 * @property bool $requiredTrue
 * @property bool $email
 * @property bool $minLength
 * @property bool $maxLength
 * @property bool $nullValidator
 * @property string $patern
 * @property int $min
 * @property int $max
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
class CrFormFieldValidator extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_form_field_validator';

	protected $casts = [
		'required' => 'bool',
		'requiredTrue' => 'bool',
		'email' => 'bool',
		'minLength' => 'bool',
		'maxLength' => 'bool',
		'nullValidator' => 'bool',
		'min' => 'int',
		'max' => 'int',
		'inscription_id' => 'int'
	];

	protected $fillable = [
		'required',
		'requiredTrue',
		'email',
		'minLength',
		'maxLength',
		'nullValidator',
		'patern',
		'min',
		'max',
		'inscription_id'
	];

	public function cr_form_fields()
	{
		return $this->hasMany(\App\Models\Courrier\CrFormField::class, 'validators_id');
	}

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}
}
