<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;


class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroINE', null, [
                'label' => 'Numéro INE',
                'attr' => [
                    'placeholder' => 'Exemple : 1234567890A',
                ],
                'constraints' => [
                    new Regex([
                        // le numéro INE doit faire une longueur de 11 caractères
                        'pattern' => '/^[A-Za-z0-9]{11}$/',
                        'message' => 'Le numéro INE doit être composé de chiffres et lettres et doit faire une longueur de 11.',
                    ]),
                ],
            ])
            ->add('nom', null, [
                'attr' => [
                    'placeholder' => 'Exemple : DUPONT',
                ],
                'constraints' => [
                    new Regex([
                        // le nom doit etre composé de lettres majuscules (avec un tiret en cas de nom composé)
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Le nom doit être composé uniquement de lettres.',
                    ])
                ],
            ])
            ->add('prenom', null, [
                'attr' => [
                    'placeholder' => 'Exemple : Jean',
                ],
                'constraints' => [
                    new Regex([
                        // Le prénom doit commencer par une majuscule et être composé uniquement de lettres
                        // ou, pour les prénoms composés, d'une majuscule suivi de lettres minuscules puis d'un tiret et d'une majuscule suivi de lettres minuscules
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Le prénom doit être composé uniquement de lettres.',
                    ])
                ],
            ])
            ->add('email', null, [
                'attr' => [
                    'placeholder' => 'Exemple : exemple@iut2.fr',
                ],
                'constraints' => [
                    new Regex([
                        // l'email doit commencer par une ou plusieurs caractères (avec un .,un - ou un _), d'un arrobase, d'un ou plusieurs caractères, d'un point, d'un ou plusieurs caractères
                        'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+$/',
                        'message' => 'L\'email doit être composé d\'un ou plusieurs caractères, d\'un arrobase, d\'un point et d\'un ou plusieurs caractères.',
                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
