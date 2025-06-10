<?php

namespace App\Model;

use Traversable;

class BillItemIterator implements \IteratorAggregate
{
    public function __construct(private readonly Bill $bill)
    {
    }

    public function getIterator(): Traversable
    {
        $items = [];
        foreach ($this->bill->getLines() as $line) {
            $items = [
                ...$items,
                ...array_fill(0, $line->getQuantity(), $line->getName()),
            ];
        }

        return new \ArrayIterator($items);
    }
}
