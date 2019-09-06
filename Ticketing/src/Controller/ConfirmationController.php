<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Buyer;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function index(Session $session)
    {
        if($session ->get('reservation') == null || !$session ->get('paiement')) {
            return $this->redirectToRoute('homepage');
        }

        $reservation = $session->get('reservation');
        $session->clear();
        return $this->render('confirmation/index.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
