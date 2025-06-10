<?php

namespace App\Twig;

use Money\Money;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PriceExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice(Money $price): string
    {
        return sprintf('%.2f %s', $price->getAmount() / 100, $price->getCurrency());
    }
}
