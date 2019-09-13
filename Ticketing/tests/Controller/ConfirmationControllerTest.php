<?php

use App\Entity\Buyer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class ConfirmationControllerTest extends WebTestCase
{
    public function testConfirmationRoute()
    {
        $client = static::createClient();
        $client->request('GET', '/confirmation');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPageConfirmation()
    {
        $session = new Session(new MockFileSessionStorage());
        $session->set('reservation', new Buyer());
        $session->set('paiement', true);

        $client = static::createClient();
        $client->getContainer()->set('session', $session);

        $crawler = $client->request('GET', '/confirmation');
        $this->assertSame(1, $crawler->filter('html h2:contains("Resumé de votre commande")')->count());
    }
}