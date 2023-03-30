<?php

namespace App\Form;

use App\Entity\CompteEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Regex;

class CompteEtudiantType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('etudiant', EtudiantType::class, [
                    'label' => false,
                ])
                ->add('login', null,
                        [
                            'label' => 'Login',
                            'attr' => [
                                'placeholder' => 'Exemple : dupontje',
                            ],
                            'constraints' => [
                                new Regex([
                                    // le login doit contenir 8 lettres minuscules
                                    'pattern' => '/^[a-zA-Z]{8}[0-9]?$/',
                                    'message' => 'Le login doit être composé de 8 lettres avec un chiffre si nécessaire.',
                                ]),
                            ],
                        ]
                )
                ->add('role', ChoiceType::class, ["mapped" => false, "choices" => ["Etudiant·e" => "ROLE_ETUDIANT", "Administrateur" => "ROLE_ADMIN"]])
                ->add('password', PasswordType::class, ["required" => false, "empty_data" => 'no change'])
                ->add('parcours', ChoiceType::class, ["choices" => ["Indéfini" => "*", "Parcours A" => "A", "Parcours B" => "B"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => CompteEtudiant::class,
        ]);
    }

}
