<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Form\ReservationFormType;
use App\Form\TicketFormType;
use Doctrine\Common\Persistence\ObjectManager;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(Request $request, Session $session)
    {
        $ticket = new Buyer();

        $form = $this -> createForm(ReservationFormType::class, $ticket);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $session -> set('reservation', $ticket);
            dump($session->get('reservation')->getNbrTickets());

            return $this -> redirectToRoute('ticket');
        }

        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $form -> createView(),
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
                    'Suisse' => 'CH','France' => 'FR','Italie' => 'IT','Autre' => 'autre',
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date('Y-m-d', strtotime('-100 years')),
                    'max' => date('Y-m-d', strtotime('-16 years'))],

            ])
            ->add('email', EmailType::class)
            ->add('typeTarif', ChoiceType::class, [
                'choices' => [
                    'Choisir billet' => '',
                    'Journée' => 0,
                    'Demi-journée' => 1,
                ]
            ])
            ->add('nbrTickets', IntegerType::class, [
                'attr' => ['min' => 1, 'max' => 10,]
            ])


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
