<?php 

namespace App\Entity;

use App\Entity\Praticien;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PraticienTest extends KernelTestCase {

    private $validator;
    
    protected function setUp() :void {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPraticien(string $nom = null, string $prenom = null, string $email = null, string $password = null, string $specialite = null, string $telephone = null) {
        $praticien = (new Praticien())->setNom($nom)
                                    ->setPrenom($prenom)
                                    ->setEmail($email)
                                    ->setPassword($password)
                                    ->setSpecialite($specialite)
                                    ->setTelephone($telephone);
        return $praticien;
    }

    public function testGetterAndSetterNom(){
        $praticien = $this->getPraticien("Dr Swaiglowdaski", "Yunislas", "Rhumatologie", "dr.Swai@live.fr", "mdp", 0601020304);
        $praticien->setNom("Dr Swaiglowdaski");
        $this->assertEquals("Dr Swaiglowdaski", $praticien->getNom());
    }

    public function testGetterAndSetterPrenom(){
        $praticien = $this->getPraticien("Dr Swaiglowdaski", "Yunislas", "Rhumatologie", "dr.Swai@live.fr", "mdp", 0601020304);
        $praticien->setPrenom("Yunislas");
        $this->assertEquals("Yunislas", $praticien->getPrenom());
    }

    public function testGetterAndSetterSpecialite(){
        $praticien = $this->getPraticien("Dr Swaiglowdaski", "Yunislas", "Rhumatologie", "dr.Swai@live.fr", "mdp", 0601020304);
        $praticien->setSpecialite("Rhumathologie");
        $this->assertEquals("Rhumathologie", $praticien->getSpecialite());
    }

    public function testGetterAndSetterTelephone(){
        $praticien = $this->getPraticien("Dr Swaiglowdaski", "Yunislas", "Rhumatologie", "dr.Swai@live.fr", "mdp", 0601020304);
        $praticien->setTelephone("0601020304");
        $this->assertEquals("0601020304", $praticien->getTelephone());
    }

    public function testNotValidBlankPrenom(){ 
        $praticien = $this->getPraticien("Dr Swaiglowdaski", "", "Rhumatologie", "dr.Swai@live.fr", "mdp", 0601020304);
        $errors = $this->validator->validate($praticien);
        $this->assertCount(1, $errors);
        $this->assertEquals("Le prènom du praticien est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidBlankPrenom");
    }

    
    public function testGetEmptyRendezVous(){
        $praticien = $this->getPraticien("Breatriun", "", "r.bre@live.fr", 0601020304, "121 Rue de Paris, Lyon");
        $this->assertCount(0, $praticien->getRendezVouses());
    }

    public function testGetNotEmptyRendezVous(){
        $praticien = $this->getPraticien("Breatriun", "", "r.bre@live.fr", 0601020304, "121 Rue de Paris, Lyon");
        $rendezVous = (new RendezVous())->setDateAndHeure( new \DateTime('2021-06-11 11:55'));
        $praticien->addRendezVouse($rendezVous);
        $this->assertCount(1, $praticien->getRendezVouses());
        $this->assertEquals($praticien, $rendezVous->getRendezVousPraticien());

    }

    public function testRemoveRendezVous(){
        $praticien = $this->getPraticien("Breatriun", "", "r.bre@live.fr", 0601020304, "121 Rue de Paris, Lyon");
        $rendezVous = (new RendezVous())->setDateAndHeure( new \DateTime('2021-06-11 11:55'));
        $praticien->addRendezVouse($rendezVous);
        $this->assertCount(1, $praticien->getRendezVouses());
        $praticien->removeRendezVouse($rendezVous);
        $this->assertCount(0, $praticien->getRendezVouses());
        $this->assertEquals(null, $rendezVous->getRendezVousPraticien());
    }

}