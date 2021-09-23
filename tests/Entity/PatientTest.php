<?php 

namespace App\tests\Entity;

use App\Entity\Patient;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase {

    private $validator;
    
    protected function setUp() :void {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPatient(string $nom = null, string $prenom  = null, string $email  = null,  string $password = null, int $telephone  = null, string $adresse  = null) {
        $patient = (new Patient())->setNom($nom)
                                ->setPrenom($prenom)
                                ->setEmail($email)
                                ->setPassword($password)
                                ->setTelephone($telephone)
                                ->setAdresse($adresse);
        return $patient;
    }

    public function testGetterAndSetterNom(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp", 0601020304, "121 Rue de Paris, Lyon");
        $patient->setNom("Beatriun");
        $this->assertEquals("Beatriun", $patient->getNom());
    }

    public function testGetterAndSetterPrenom(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $patient->setPrenom("Rosalia");
        $this->assertEquals("Rosalia", $patient->getPrenom());
    }

    public function testGetterAndSetterEmail(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $patient->setEmail("david.dupond@live.fr");
        $this->assertEquals("david.dupond@live.fr", $patient->getEmail());
    }

    public function testGetterAndSetterTelephone(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $patient->setTelephone("0601020304");
        $this->assertEquals("0601020304", $patient->getTelephone());
    }

    public function testGetterAndSetterAdresse(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr","mdp", 0601020304, "121 Rue de Paris, Lyon");
        $patient->setAdresse("121 Rue de Paris, Lyon");
        $this->assertEquals("121 Rue de Paris, Lyon", $patient->getAdresse());
    }

    public function testIsPrenomValid(){   
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");   
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    public function testNotValidBlankPrenom(){ 
        $patient = $this->getPatient("Breatriun", "", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Le prènom du patient est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidBlankPrenom");

    }

    public function testGetEmptyRendezVous(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $this->assertCount(0, $patient->getRendezVouses());
    }

    public function testGetNotEmptyRendezVous(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp",0601020304, "121 Rue de Paris, Lyon");
        $rendezVous = (new RendezVous())->setDateAndHeure( new \DateTime('2021-06-11 11:55'));
        $patient->addRendezVouse($rendezVous);
        $this->assertCount(1, $patient->getRendezVouses());
        $this->assertEquals($patient, $rendezVous->getRendezVousPatient());

    }

    public function testRemoveRendezVous(){
        $patient = $this->getPatient("Breatriun", "Rosalia", "r.bre@live.fr", "mdp", 0601020304, "121 Rue de Paris, Lyon");
        $rendezVous = (new RendezVous())->setDateAndHeure( new \DateTime('2021-06-11 11:55'));
        $patient->addRendezVouse($rendezVous);
        $this->assertCount(1, $patient->getRendezVouses());
        $patient->removeRendezVouse($rendezVous);
        $this->assertCount(0, $patient->getRendezVouses());
        $this->assertEquals(null, $rendezVous->getRendezVousPatient());
    }
}