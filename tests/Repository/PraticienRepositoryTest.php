<?php

namespace App\tests\Repository;

use App\Entity\Praticien;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\PraticienFixture;
use App\Repository\PraticienRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class PraticienRepositoryTest extends KernelTestCase {
    use FixturesTrait;

    private $repository;

    protected function setUp() :void {
        self::bootKernel();
        $this->repository = self::$container->get(PraticienRepository::class);
    }
    
    function testFindBy(){
        $this->loadFixtures([PraticienFixture::class]);
        $praticiens = $this->repository->findBy(["prenom" => "Yunislas 1"]);
        $this->assertCount(1, $praticiens);
    }
    
    function testFindAll(){
        // Exécution du setUp ..
        // Insérer 5 clients
        $this->loadFixtures([PraticienFixture::class]);
        $praticiens = $this->repository->findAll();
        $this->assertCount(5, $praticiens);
        // execution du tearDown ..
    }

    function testManagerPersist(){
        $this->loadFixtures([AppFixtures::class]);
        $praticien = (new Praticien())->setPrenom("Dr Swaiglowdaski")
                                        ->setNom("Yunislas")
                                        ->setEmail("dr.Swai@live.fr")
                                        ->setPassword("mdp")
                                        ->setSpecialite("2 rue de Paris, Lyon")
                                        ->setTelephone("0102030405");
                             
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($praticien);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }
    
    protected function tearDown() :void {
        // $this->loadFixtures([AppFixtures::class]);
    }
}