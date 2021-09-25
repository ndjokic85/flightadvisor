<?php

namespace App\Http\Requests\Api\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class RouteIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source' => [
                'numeric',
                'required',
                'exists:airports,id'
            ],
            'destination' => [
                'numeric',
                'required',
                'exists:airports,id'
            ]
        ];
    }
}
