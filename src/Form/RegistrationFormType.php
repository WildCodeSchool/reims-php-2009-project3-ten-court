<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, [
            'label' => 'Email',
            'attr' => [
                'placeholder' => 'Ex: prenom-nom@gmail.com'
            ]
        ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter les termes et conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes et conditions',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
                'invalid_message' => 'Le mot de passe doit être identique',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ))
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Ex: Albert51'
                ]
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe',
                'choices'  => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                    'Autre' => 'autre',
                ]
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'choices'  => [
                    'Débutant' => 'debutant',
                    'Intermediaire' => 'intermediaire',
                    'Expert' => 'expert',
                    'Professionnel' => 'professionnel',
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ex: Toulouse'
                ]
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'format' => 'dd-MM-yyyy'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Soumettre',
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}