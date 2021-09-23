<?php

namespace App\Http\Requests\Api\v1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CityPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|max:65535|string',
            'country_id' => 'required|numeric|exists:countries,id'
        ];
    }
}
