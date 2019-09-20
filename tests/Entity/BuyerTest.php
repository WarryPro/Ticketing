<?php

namespace App\Tests\Entity;

use App\Entity\Buyer;
use App\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
//    /**
//     * @doesNotPerformAssertions
//     */
    public function testGetTotalNotNull()
    {
        $date = new \DateTime();
        $dateNaissance = $date->setDate(1991, 3, 21);

        $reservation = new Buyer();
        

        $reservation->setDateVisite($date->setDate(2019,9,13));
        $reservation->setEmail('dannyfr.03@gmail.com');
        $reservation->setDateReservation($date);
        $reservation->setNbrTickets(2);
        $reservation->setTypeTarif(0);
        $reservation->setCodeReservation(substr(sha1(random_bytes(10)), 0, 10));

        $ticket1 = new Ticket();
        $ticket1->setDateNaissance($dateNaissance);
        $ticket1->setBuyer($reservation);
        $ticket1->setNom('Restrepo');
        $ticket1->setPrenom('Dany');
        $ticket1->setPays('CH');
        $ticket1->setReduction(0);
        $ticket1->setTarif(16);
        
        $ticket2 = new Ticket();
        $ticket2->setDateNaissance($dateNaissance);
        $ticket2->setBuyer($reservation);
        $ticket2->setNom('Test');
        $ticket2->setPrenom('Test');
        $ticket2->setPays('CH');
        $ticket2->setReduction(false);
        $ticket2->setTarif(16);

        $reservation->addTicket($ticket1);
        $reservation->addTicket($ticket2);
        $reservation->setTotal($ticket1->getTarif() + $ticket2->getTarif());

        $result = $reservation->getTotal();

        $this->assertNotNull($result);
        $this->assertSame(32.0, $result);

    }



    public function testGetNbrTicketsNotNull()
    {
        $date = new \DateTime();
        $dateNaissance = $date->setDate(1991, 3, 21);

        $reservation = new Buyer();


        $reservation->setDateVisite($date->setDate(2019,9,13));
        $reservation->setEmail('dannyfr.03@gmail.com');
        $reservation->setDateReservation($date);
        $reservation->setTypeTarif(0);
        $reservation->setCodeReservation(substr(sha1(random_bytes(10)), 0, 10));

        $ticket1 = new Ticket();
        $ticket1->setDateNaissance($dateNaissance);
        $ticket1->setBuyer($reservation);
        $ticket1->setNom('Restrepo');
        $ticket1->setPrenom('Dany');
        $ticket1->setPays('CH');
        $ticket1->setTarif(16);

        $reservation->addTicket($ticket1);

        $result = count($reservation->getTickets());

        $this->assertNotNull($result);
        $this->assertGreaterThan(0, $result);

    }
}
