<?php 

namespace App\tests\Entity;

use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RendezVousTest extends KernelTestCase {

    private $validator;
    
    protected function setUp() :void {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getRendezVous(\DateTime $dateAndHeure = null) {
        $rendezVous = (new RendezVous())->setDateAndHeure($dateAndHeure);
        return $rendezVous;
    }

    public function testGetterAndSetterDateAndHeure(){
        $rendezVous = $this->getRendezVous(new \DateTime("2020-12-21"));
        $rendezVous->setDateAndHeure(new \DateTime("2020-12-21"));
        $this->assertEquals((new \DateTime("2020-12-21")), $rendezVous->getDateAndHeure());
    }
}