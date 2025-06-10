<?php

namespace App\Validator;

class BillValidator
{
    private const REGEX = '/^IN-%s-\d{3}$/';

    public function validate(array $data): array
    {
        $date = date('Ymd');
        $regex = sprintf(self::REGEX, $date);

        // Verify bill ID
        if (!preg_match($regex, $data['id'])) {
            $error = sprintf(
                'Invoice number is "%s". Expected to be "IN-%s-XXX" (X = number).',
                $data['id'],
                $date
            );

            return [$error];
        }

        return [];
    }
}
