<?php

namespace App\Model;

use Money\Money;

class BillLine
{
    public function __construct(
        private string $name,
        private int    $quantity,
        private Money  $unitPrice,
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getPrice(): Money
    {
        return $this->unitPrice->multiply($this->quantity);
    }
}
