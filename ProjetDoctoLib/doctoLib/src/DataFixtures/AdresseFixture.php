<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AdresseFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i < 5 ; $i++) { 
            $adresse =new Adresse();
            $adresse->setNumeroVoie("180$i")
                    ->setRue("Rue de Louis $i")
                    ->setCodePostal("340$i")
                    ->setVille("Lille $i");

            $manager->persist($adresse);
        }
        $manager->flush();
    }
}
