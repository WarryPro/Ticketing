<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Price;

class PriceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $price = new Price();
//        Delcaration des differents prix par défaut
        $price -> setNormal(16)
                ->setEnfant(8)
                ->setSenior(12)
                ->setReduit(10)
                ->setGratuit(0);

        $manager -> persist($price); //préparation à le faire persister dans le temps

        $manager->flush(); //insère dans la BDD
    }
}
