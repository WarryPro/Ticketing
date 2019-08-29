<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Buyer;
use App\Form\ReservationFormType;
use App\Repository\BuyerRepository;
use Doctrine\Common\Persistence\ObjectManager;

class HomepageController extends AbstractController
{
    /**
     * @var BuyerRepository
     */
    private $buyerRepository;
    /**
     * @var ObjectManager
     */
    private $objectManager;
    public function __construct(BuyerRepository $buyerRepository, ObjectManager $objectManager)
    {
        $this->buyerRepository = $buyerRepository;
        $this->objectManager = $objectManager;
    }


    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, Session $session)
    {

        $ticket = new Buyer();
        $form = $this -> createForm(ReservationFormType::class, $ticket);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $session -> set('reservation', $ticket);

            return $this -> redirectToRoute('reservation');
        }

        return $this->render('homepage/index.html.twig', [
            'form' => $form -> createView(),
        ]);
//        return $this->render('homepage/index.html.twig', [
//            'controller_name' => 'HomepageController',
//        ]);
    }
}
