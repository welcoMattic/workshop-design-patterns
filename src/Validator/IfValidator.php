<?php

namespace App\Validator;

use App\Model\Bill;

class IfValidator implements BillValidatorInterface
{
    public function __construct(
        private readonly BillValidatorInterface $if,
        private readonly BillValidatorInterface $then,
    ) {
    }

    public function validate(Bill $bill): array
    {
        $if = $this->if->validate($bill);
        if (count($if)) {
            return [];
        }

        return $this->then->validate($bill);
    }
}
