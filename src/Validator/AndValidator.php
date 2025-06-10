<?php

namespace App\Validator;

use App\Model\Bill;

class AndValidator implements BillValidatorInterface
{
    public function __construct(
        /** @var BillValidatorInterface[] */
        private array $validators,
    ) {
    }

    public function validate(Bill $bill): array
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $errors = array_merge($errors, $validator->validate($bill));
        }

        return $errors;
    }
}
