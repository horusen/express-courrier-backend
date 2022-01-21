<?php

namespace App\Http\Requests\Messagerie;

use Illuminate\Foundation\Http\FormRequest;

class DiscussionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|integer|exists:type_discussions,id',
            'user1' => 'required_if:type,1|integer|exists:inscription,id',
            'user2' => 'required_if:type,1|integer|exists:inscription,id',
            'user' => 'required_if:type,2|integer|exists:inscription,id',
            'structure' => 'required_if:type,2|integer|exists:structures,id',
        ];
    }
}
