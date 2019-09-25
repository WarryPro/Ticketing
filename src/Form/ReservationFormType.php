<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 01/05/2019
 * Time: 01:30
 */
namespace App\Form;

use App\Entity\Buyer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeTarif', ChoiceType::class, [
                'choices' => [
                    'Journée' => 0,
                    'Demi-journée' => 1,
                ],
                'expanded' => true, // Pour afficher en radio buttons
            ])

            ->add('dateVisite', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date('Y-m-d'),
                            'max' => date('Y-m-d', strtotime('+1 years')),
                            'value' => date('Y-m-d')],
            ])

            ->add('nbrTickets', IntegerType::class, [
                'attr' => ['min' => 1, 'max' => 10,]
            ])

            ->add('tickets', CollectionType::class, [
                'entry_type'    => TicketFormType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'by_reference'  => false
            ])
            ->add('Suivant', SubmitType::class, [
                    'attr' => ['id' => 'add-form', 'class' => 'btn btn-primary btn-block']
            ]);


//        if($options['after14hours']->format('H-i') >= '14:00') {
//            $builder
//                ->add('typeTarif', ChoiceType::class, [
//                    'choices' => [
//                        'Demi-journée' => 1,
//                    ],
//                    'expanded' => true, // Pour afficher en radio buttons
//                ]);
//        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Buyer::class,
            'after14hours' => new \DateTime(),
        ]);

    }


}