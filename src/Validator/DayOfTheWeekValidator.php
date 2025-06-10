<?php

namespace App\Validator;

use App\Model\Bill;

/**
 * Validate that the day of the week is the expected one.
 */
class DayOfTheWeekValidator implements BillValidatorInterface
{
    /**
     * @param int $dayOfTheWeek
     */
    public function __construct(private readonly int $dayOfTheWeek)
    {
    }

    public function validate(Bill $bill): array
    {
        $today = (int) date('N');

        if ($today !== $this->dayOfTheWeek) {
            return ['The day of the week is not the expected one.'];
        } else {
            return [];
        }
    }
}
