<?php

namespace App\Form;

use App\Entity\TennisMatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startHour')
            ->add('endHour')
            ->add('name')
            ->add('adress')
            ->add('description')
            ->add('organizer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TennisMatch::class,
        ]);
    }
}
