<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Jan 2022 03:13:45 +0000.
 */

namespace App\Models\Courrier;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CrFormField
 *
 * @property int $id
 * @property string $libelle
 * @property string $label
 * @property string $value
 * @property string $type
 * @property bool $required
 * @property int $inscription_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Inscription $inscription
 * @property \Illuminate\Database\Eloquent\Collection $cr_form_field_validators
 * @property \Illuminate\Database\Eloquent\Collection $cr_form_field_values
 *
 * @package App\Models
 */
class CrFormField extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cr_nature_form_field';

	protected $casts = [
		'required' => 'bool',
		'inscription_id' => 'int',
        'validators_id' => 'int',
        'nature_id'=> 'int'
	];

	protected $fillable = [
		'libelle',
		'label',
		'value',
		'type',
		'required',
        'validators_id',
		'inscription_id',
        'nature_id'
	];

	public function inscription()
	{
		return $this->belongsTo(\App\Models\Inscription::class);
	}

    public function cr_nature()
	{
		return $this->belongsTo(\App\Models\Courrier\CrNature::class, 'nature_id');
	}

	public function cr_form_field_validator()
	{
		return $this->belongsTo(\App\Models\Courrier\CrFormFieldValidator::class, 'validators_id');
	}

	public function cr_form_field_values()
	{
		return $this->hasMany(\App\Models\Courrier\CrFormFieldValue::class, 'form_field_id');
	}
}
