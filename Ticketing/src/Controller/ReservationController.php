<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Form\ReservationFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\StripeService;
use App\Service\PriceCalcul;
use Swift_Mailer;
use Swift_Message;

class ReservationController extends AbstractController
{
    /**
     * @var $objectManager
     */
    private $objectManager;

    /**
     * @var $stripeService
     */
    private $stripeService;

    /**
     * @var $priceCalcul
     */
    private $priceCalcul;

    public function __construct(ObjectManager $objectManager, StripeService $stripeService, PriceCalcul $priceCalcul)
    {
        $this -> priceCalcul = $priceCalcul;
        $this -> objectManager = $objectManager;
        $this -> stripeService = $stripeService;
    }


    /**
     * @Route("/reservation", name="reservation")
     * @param Request $request
     * @param Session $session
     * @param Swift_Mailer $mailer
     * @return Response
     * @Route({"GET", "POST"})
     */
    public function index(Request $request, Session $session, Swift_Mailer $mailer)
    {
        if ($session->get('reservation') == null) {
            return $this->redirectToRoute('/');
        }
        $reservation = $session->get('reservation');
        $total = $this->priceCalcul->priceCalcul($reservation);
        dump($reservation);

        if ($request->get('stripeEmail')) {
            $reservation->setEmail($request->request->get('stripeEmail'));
            $payment = $this->stripeService->stripePayment($total, $request->get('stripeToken')); // obtained with Stripe.js
            if ($payment == true) {
                $session->set("paiement", true);
                $reservation->setTotal($total);
                $this->objectManager->persist($reservation);
                $this->objectManager->flush();

                $message = (new Swift_Message('Confirmation de commande - Billet Musée du Louvre'))
                    ->setFrom('dannyfr.03@gmail.com')
                    ->setTo($reservation->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'emails/confirmation.html.twig',
                            ['reservation' => $reservation]
                        ),
                        'text/html'
                    );
                $mailer -> send($message);

                return $this->redirectToRoute('confirmation');
            } else {
                $this->addFlash('error', 'Une erreur est survenue, merci de réessayer.');
            }
        }
        $session->set('reservation', $reservation);
        return $this->render('reservation/index.html.twig', [
            'reservation' => $reservation,
            'total' => $total
        ]);
    }


    /**
        * @Route("/reservation/ticket", name="ticket")
        * @Route({"GET", "POST"}) //@Method changée par route
    */
    public function create(Request $request, ObjectManager $manager, Session $session)
    {
        dump($request, $session);
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
                    'Journée' => [0, 'attr' => ['disabled' => true]],
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
