<?php

namespace App\Validator;

use App\Model\Bill;

class BillValidator
{
    private const REGEX = '/^IN-%s-\d{3}$/';

    public function validate(Bill $bill): array
    {
        $date = date('Ymd');
        $regex = sprintf(self::REGEX, $date);

        // Verify bill ID
        if (!preg_match($regex, $bill->getId())) {
            $error = sprintf(
                'Invoice number is "%s". Expected to be "IN-%s-XXX" (X = number).',
                $bill->getId(),
                $date
            );

            return [$error];
        }

        return [];
    }
}
