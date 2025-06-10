<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class)
            ->add('lines', CollectionType::class, [
                'entry_type' => BillLineType::class,
            ])
            ->add('submit', SubmitType::class)
            ->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) {
                $data = $event->getData();
                $linesCleaned = [];
                foreach ($data['lines'] as $line) {
                    if ($line['name'] !== null || $line['unit_price_in_cents'] !== null) {
                        $linesCleaned[] = $line;
                    }
                }

                $data['lines'] = $linesCleaned;

                $event->setData($data);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $empty = [
        ];
        $resolver->setDefault('data', [
            'lines' => [$empty, $empty, $empty, $empty, $empty, $empty, $empty],
        ]);
    }
}
