<?php

use App\Entity\Buyer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class ReservationControllerTest extends WebTestCase
{
    public function testReservationRoute()
    {
        $client = static::createClient();
        $client->request('GET', '/reservation');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPageReservation()
    {
        $session = new Session(new MockFileSessionStorage());
        $session->set('reservation', new Buyer());
        $client = static::createClient();
        $client->getContainer()->set('session', $session);
        $crawler = $client->request('GET', '/reservation');
        $this->assertSame(1, $crawler->filter('html div.checkout:contains("Total")')->count());
    }
}
