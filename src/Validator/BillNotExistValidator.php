<?php

namespace App\Validator;

use App\Model\Bill;
use App\Repository\BillRepository;

class BillNotExistValidator implements BillValidatorInterface
{
    public function __construct(
        private readonly BillRepository $billRepository,
    )
    {
    }

    public function validate(Bill $bill): array
    {
        try {
            $bill = $this->billRepository->getBill($bill->getId());
        } catch (\Throwable $exception) {
            return [];
        }

        return ['The bill already exists.'];
    }
}