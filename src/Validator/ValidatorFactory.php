<?php

namespace App\Validator;

class ValidatorFactory
{
    public function createValidator(): BillValidatorInterface
    {
        return new BillValidator();
    }
}
