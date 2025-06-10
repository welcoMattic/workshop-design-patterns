<?php

namespace App\Validator;

class ValidatorFactory
{
    public function createValidator(): BillValidatorInterface
    {
        return new ValidateAllValidator([
            new BillIdValidator(),
            new PositivePriceValidator(),
            new IfValidator(
                new DayOfTheWeekValidator(4),
                new MinimumAmountValidator(100),
            ),
            new IfValidator(
                new DayOfTheWeekValidator(5),
                new MinimumAmountValidator(99),
            ),
            new IfValidator(
                new NotValidator(
                    new DayOfTheWeekValidator(3),
                    'On est pas mercredi'
                ),
                new LineValidator('pizza'),
            ),
            new IfValidator(
                new LineValidator('sel'),
                new LineValidator('poivre'),
            ),
            new IfValidator(
                new LineValidator('patates'),
                new NotValidator(
                    new LineValidator('pates'),
                    'Quand y\'a des patates, pas de pates.',
                )
            )
        ]);

        // pas de facture avec le même numéro
    }
}
