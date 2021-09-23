<?php

namespace App\Validators\Imports;

use App\Validators\IValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AirportImportValidator implements IValidator
{
    public function check(array $attributes): bool
    {
        $validator = Validator::make($attributes, [
            'city' => [
                'required',
                'string',
                'exists:cities,name'
            ],
            'name' => [
                'required',
                'string',
            ],
            'iata' => [
                'string',
            ],
            'icao' => [
                'string',
            ],
            'id' => [
                'required',
                'numeric',
            ],
            'latitude' => [
                'required',
                'numeric',
            ],
            'longitude' => [
                'required',
                'numeric',
            ],
            'altitude' => [
                'required',
                'numeric',
            ],
            'dst' => [
                'required',
                'string',
                Rule::in(['E', 'A', 'S', 'O', 'Z', 'U', 'N'])
            ],
            'tz' => [
                'required',
                'string'
            ],
            'type' => [
                'required',
                'string'
            ],
            'source' => [
                'required',
                'string'
            ]
        ]);
        return !$validator->fails();
    }
}
