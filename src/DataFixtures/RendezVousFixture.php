<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Praticien;
use App\Entity\RendezVous;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RendezVousFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i < 5 ; $i++) { 
            $rendezVous =new RendezVous();
            $rendezVous->setRendezVousPatient((new Patient)->setNom("Ratsuya $i")
                                                        ->setPrenom("Eldright $i")
                                                        ->setEmail("Eld.ra$i@live.fr")
                                                        ->setTelephone("0102030405")
                                                        ->setAdresse("$i rue de Paris, Lyon")
                                                        ->setPassword("mdp$i")
                                                )
                        ->setRendezVousPraticien((new Praticien)->setNom("Dr Swaiglowdaski $i")
                                                                ->setPrenom("Yunislas $i")
                                                                ->setEmail("dr.Swai$i@live.fr")
                                                                ->setPassword("mdp$i")
                                                                ->setTelephone("0102030405")
                                                                ->setSpecialite("Rhumatologie $i")
                                                )
                        ->setDateAndHeure(new \DateTime("2020-01-$i"));

            $manager->persist($rendezVous);
        }
        $manager->flush();
    }
}
