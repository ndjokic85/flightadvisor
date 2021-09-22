<?php

namespace App\Validators;

interface IValidator
{
    public function check(array $attributes): bool;
}
