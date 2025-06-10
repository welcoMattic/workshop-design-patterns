<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BillLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('unit_price_in_cents', NumberType::class)
            ->add('quantity', NumberType::class)
            ->add('currency', ChoiceType::class, ['choices' => ['EUR' => 'EUR', 'USD' => 'USD']])
        ;
    }
}
