<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 25/05/2019
 * Time: 01:43
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use App\Entity\Ticket;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date('Y-m-d', strtotime('-120 years')),
                    'max' => date('Y-m-d', strtotime('-16 years'))],
            ])
            ->add('pays', ChoiceType::class, [
                'choices' => [
                    'Votre nationalité' => '',
                    'Suisse' => 'CH','France' => 'FR','Italie' => 'IT','Autre' => 'autre',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }

}