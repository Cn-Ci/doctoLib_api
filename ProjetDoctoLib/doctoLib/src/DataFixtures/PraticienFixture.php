<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Praticien;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PraticienFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i < 5 ; $i++) { 
            $praticien =new Praticien();
            $praticien->setNom("Dr Swaiglowdaski $i")
                        ->setPrenom("Yunislas $i")
                        ->setEmail("dr.Swai$i@live.fr")
                        ->setPassword("mdp$i")
                        ->setTelephone("0102030405")
                        ->setSpecialite("Rhumatologie $i");

            $manager->persist($praticien);
        }
        $manager->flush();
    }
}
