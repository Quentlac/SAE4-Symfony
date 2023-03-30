<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\GreaterThan;

class OffreType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('entreprise')
                ->add('intitule')
                ->add('descriptif')
                ->add('dateDepot', DateType::class, [
                    'widget' => 'single_text',
                    'constraints' => [
                        new LessThanOrEqual(
                            [
                                'value' => new \DateTime(), 'message' => '',
                            ])
                    ],
                    'help' => 'La date de dépot doit être inférieure ou égale à la date du jour.'
                ])
                ->add('parcours', ChoiceType::class, ["choices" => ["Indéfini" => "*", "Parcours A" => "A", "Parcours B" => "B"]])
                ->add('motsCles', null, [
                    'attr' => [
                        'placeholder' => 'Exemple : Java; Symfony; Angular',
                    ],
                    'help' => 'Séparez les mots clés par un point-virgule.'
                ])
                ->add('urlPieceJointe', null, [
                    'constraints' => [
                        new Url(['message' => 'L\'url n\'est pas valide.'])
                    ],
                    'attr' => [
                        'placeholder' => 'Exemple : https://exemple',
                    ],

                ])
                ->add('etatOffre')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }

}
