<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PatientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i < 5 ; $i++) { 
            $patient =new Patient();
            $patient->setNom("Ratsuya $i")
                    ->setPrenom("Eldright $i")
                    ->setEmail("Eld.ra$i@live.fr")
                    ->setTelephone("0102030405")
                    ->setAdresse("$i rue de Paris, Lyon")
                    ->setPassword("mdp$i");

            $manager->persist($patient);
        }


        $manager->flush();
    }
}
