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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Nom'],
                'label' => false
            ])

            ->add('prenom', TextType::class, [
                'attr' => ['placeholder' => 'Prénom'],
                'label' => false
            ])

            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date('Y-m-d', strtotime('-120 years')),
                'max' => date('Y-m-d', strtotime('-16 years'))],
                'label' => false
            ])

            ->add('pays', ChoiceType::class, [
                'choices' => [
                    'Votre nationalité' => '',
                    'Suisse' => 'CH','France' => 'FR','Italie' => 'IT','Autre' => 'autre', ],
                'label' => false
            ])

            ->add('reduction', CheckboxType::class,array(
                'label' => 'Tarif réduit (Vous devez presenter un justificatif à l\'entrée du musée)',
                'label_attr' => array(
                    'class' => 'col-form-label',
                    'id' => 'reduction',
                    'for' => 'reduction'),
                'attr' => array(
                    'class' => 'form-control'),
                'required' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }

}