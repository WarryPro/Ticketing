<?php

namespace App\Tests\Service;

use App\Entity\Buyer;
use App\Entity\Ticket;
use App\Service\PriceCalcul;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PriceCalculTest extends WebTestCase
{

    public function testReduction()
    {

        $reservation = new Buyer();
        $reservation->setEmail('dannyfr@gmail.com');
        $reservation->setTypeTarif(0);

        $ticket = new Ticket();
        $ticket->setNom('Restrepo');
        $ticket->setPrenom('Dany');
        $ticket->setDateNaissance(new \DateTime('1991-3-21'));
        $ticket->setReduction(true);
        $ticket->setPays('CH');

        $reservation->addTicket($ticket);
        $priceCalcul = new PriceCalcul();
        $result = $priceCalcul->priceCalcul($reservation);
        $this->assertNotNull($result);
        $this->assertSame(10, $result);
    }
}
