<?php

namespace App\tests\Repository;

use App\Entity\Patient;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\PatientFixture;
use App\Repository\PatientRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class PatientRepositoryTest extends KernelTestCase {
    use FixturesTrait;

    private $repository;

    protected function setUp() :void {
        self::bootKernel();
        $this->repository = self::$container->get(PatientRepository::class);
    }
    
    function testFindBy(){
        $this->loadFixtures([PatientFixture::class]);
        $patients = $this->repository->findBy(["prenom" => "Eldright 1"]);
        $this->assertCount(1, $patients);
    }
    
    function testFindAll(){
        // Exécution du setUp ..
        // Insérer 5 clients
        $this->loadFixtures([PatientFixture::class]);
        $patients = $this->repository->findAll();
        $this->assertCount(5, $patients);
        // execution du tearDown ..
    }

    function testManagerPersist(){
        $this->loadFixtures([AppFixtures::class]);
        $patient = (new Patient())->setPrenom("Ratsuya")
                                ->setNom("Eldright")
                                ->setEmail("Eld.ra@live.fr")
                                ->setTelephone("0102030405")
                                ->setAdresse("2 rue de Paris, Lyon")
                                ->setPassword("mdp");
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($patient);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }
    
    protected function tearDown() :void {
        // $this->loadFixtures([AppFixtures::class]);
    }
}