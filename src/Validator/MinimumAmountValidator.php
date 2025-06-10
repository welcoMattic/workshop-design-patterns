<?php

namespace App\Validator;

use App\Model\Bill;

class MinimumAmountValidator implements BillValidatorInterface
{
    public function __construct(private readonly int $amountInCents)
    {
    }

    public function validate(Bill $bill): array
    {
        if ($bill->getTotalPrice()->getAmount() < $this->amountInCents) {
            return ['The amount is less than the minimum amount.'];
        } else {
            return [];
        }
    }
}