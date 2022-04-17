<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int[] teams_ids
 */
class CreateFixtureRequest extends FormRequest
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
            'teams_ids' => 'required|array|min:2',
            'teams_ids.*' => 'required|numeric|exists:App\Models\Team,id',
        ];
    }
}