<?php 

namespace App\Entity;

use App\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdresseTest extends KernelTestCase {

    private $validator;
    
    protected function setUp(): void {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getAdresse(int $numeroVoie, string $rue, int $codePostal, string $ville) {
        $adresse = (new Adresse())->setNumeroVoie($numeroVoie)
                                ->setRue($rue)
                                ->setCodePostal($codePostal)
                                ->setVille($ville);
        return $adresse;
    }

    public function testGetterAndSetterNumeroVoie() :void{
        $adresse = $this->getAdresse(121, "rue de Paris", 69000, "Lyon");
        $adresse->setNumeroVoie(121);
        $this->assertEquals(121, $adresse->getNumeroVoie());
    }

    public function testGetterAndSetterRue(){
        $adresse = $this->getAdresse(121, "rue de Paris", 69000, "Lyon");
        $adresse->setRue("Rue de Paris");
        $this->assertEquals("Rue de Paris", $adresse->getRue());
    }

    public function testGetterAndSetterCodePostal(){
        $adresse = $this->getAdresse(121, "rue de Paris", 69000, "Lyon");
        $adresse->setCodePostal(69000);
        $this->assertEquals(69000, $adresse->getCodePostal());
    }

    public function testGetterAndSetterVille(){
        $adresse = $this->getAdresse(121, "rue de Paris", 69000, "Lyon");
        $adresse->setVille("Lyon");
        $this->assertEquals("Lyon", $adresse->getVille());
    }

    public function testNotValidBlankPrenom(){ 
        $adresse = $this->getAdresse(121, "", 69000, "Lyon");
        $errors = $this->validator->validate($adresse);
        $this->assertCount(1, $errors);
        $this->assertEquals("L'addresse est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidBlankPrenom");
    }
}