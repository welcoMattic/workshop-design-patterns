<?php

namespace App\Validator;

use App\Model\Bill;

class NotValidator implements BillValidatorInterface
{
    public function __construct(
        private readonly BillValidatorInterface $validator,
        private readonly string $errorMessage,
    ) {
    }

    public function validate(Bill $bill): array
    {
        $errors = $this->validator->validate($bill);
        if (count($errors) > 0) {
            return [];
        }

        return [$this->errorMessage];
    }
}