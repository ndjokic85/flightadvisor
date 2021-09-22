<?php

namespace App\Validators\Imports;

use App\Validators\IValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RouteImportValidator implements IValidator
{
    public function check(array $attributes): bool
    {
        $validator = Validator::make($attributes, [
            'destination_airport_id' => [
                'required',
                'numeric',
                'exists:airports,id'
            ],
            'source_airport_id' => [
                'required',
                'numeric',
                'exists:airports,id'
            ],
            'stops' => [
                'required',
                'numeric',
            ],
            'price' => [
                'required',
                'numeric',
            ],
        ]);

        return !$validator->fails();
    }
}
