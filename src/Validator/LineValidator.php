<?php

namespace App\Validator;

use App\Model\Bill;

class LineValidator implements BillValidatorInterface
{

    /**
     * @param string $name
     */
    public function __construct(private readonly string $name)
    {
    }

    public function validate(Bill $bill): array
    {
        foreach ($bill->getLines() as $line) {
            if ($line->getName() === $this->name) {
                return [];
            }
        }

        return [
            sprintf('The line with name "%s" is missing.', $this->name)
        ];
    }
}
