<?php

namespace App\Model;

use Doctrine\Common\Collections\Collection;
use Money\Money;

class Bill
{
    public function __construct(
        private string $id,
        /** @var Collection<int, BillLine> */
        private Collection $lines,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): \Traversable
    {
        return new BillItemIterator($this);
    }

    public function getTotalPrice(): Money
    {
        if ($this->lines->isEmpty()) {
            return Money::EUR(0);
        }

        $currency = $this->lines->first()->getPrice()->getCurrency();
        $total = new Money(0, $currency);
        foreach ($this->lines as $line) {
            $total = $total->add($line->getPrice());
        }

        return $total;
    }

    /**
     * @return Collection<int, BillLine>
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }
}