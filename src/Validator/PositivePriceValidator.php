<?php

namespace App\Validator;

use App\Model\Bill;

class PositivePriceValidator implements BillValidatorInterface
{
    public function validate(Bill $bill): array
    {
        $errors = [];
        foreach ($bill->getLines() as $line) {
            if ($line->getPrice()->getAmount() < 0) {
                $errors[] = sprintf(
                    'Le prix du produit "%s" ne peut pas être négatif.',
                    $line->getName(),
                );
            }
        }

        return $errors;
    }
}
