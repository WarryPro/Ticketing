<?php

namespace App\Controller;

use App\Entity\Buyer;
use Doctrine\Common\Persistence\ObjectManager;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index()
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }


    /**
     * @Route("/reservation/ticket", name="ticket")
     * @Route({"GET", "POST"}) //@Method changée par route
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ticket = new Buyer();

        $form = $this -> createFormBuilder($ticket)
                      ->add('nom')
                      ->add('prenom')
                      ->add('pays', ChoiceType::class, [
                          'choices' => [
                              'Votre nationalité' => '',
                              'Suisse' => 'CH',
                              'France' => 'FR',
                              'Italie' => 'IT',
                              'Autre' => 'autre',
                              ]
                      ])
                      ->add('dateNaissance', DateType::class, [
                          'widget' => 'single_text',
                          'attr' => ['max' => date('2001-12-31'), 'min' => date('1930-01-31')],

                      ])
                      ->add('email', EmailType::class)
                      ->add('typeTarif', ChoiceType::class, [
                          'choices' => [
                              'Choisir billet' => '',
                              'Journée' => 0,
                              'Demi-journée' => 1,
                          ]
                      ])
                      ->add('nbrTickets', NumberType::class)


                      ->getForm();

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $ticket -> setDateReservation(new \DateTime());
            $manager -> persist($ticket);
            $manager -> flush();
        }

        return $this -> render('reservation/tickets.html.twig',[

                'formTicket' => $form -> createView()
        ]);


    }
}
