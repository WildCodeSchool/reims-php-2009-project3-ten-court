<?php

namespace App\Form;

use App\Entity\TennisMatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adress', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('startHour', DateTimeType::class, [
                'label' => 'Date de début'
            ])
            ->add('endHour', DateTimeType::class, [
                'label' => 'Date de fin'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Chercher',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TennisMatch::class,
        ]);
    }
}
