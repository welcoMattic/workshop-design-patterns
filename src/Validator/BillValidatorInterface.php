<?php

namespace App\Validator;

use App\Model\Bill;

interface BillValidatorInterface
{
    /**
     * @return string[]
     */
    public function validate(Bill $bill): array;
}
