<?php

namespace App\tests\Repository;

use App\Entity\Patient;
use App\Entity\Praticien;
use App\Entity\RendezVous;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\RendezVousFixture;
use App\Repository\RendezVousRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class RendezVousRepositoryTest extends KernelTestCase {
    use FixturesTrait;

    private $repository;

    protected function setUp() :void {
        self::bootKernel();
        $this->repository = self::$container->get(RendezVousRepository::class);
    }
    
    function testFindBy(){
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVouses = $this->repository->findBy(["dateAndHeure" => ((new \DateTime ("2020-01-01"))) ]);                                                                          
        $this->assertCount(1, $rendezVouses);
    }
    
    function testFindAll(){
        // Exécution du setUp ..
        // Insérer 5 clients
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVouses = $this->repository->findAll();
        $this->assertCount(5, $rendezVouses);
        // execution du tearDown ..
    }

    function testManagerPersist(){
        $this->loadFixtures([AppFixtures::class]);
        $rendezVous = (new RendezVous())->setRendezVousPatient((new Patient)->setNom("Ratsuya")
                                                                            ->setPrenom("Eldright ")
                                                                            ->setEmail("Eld.ra@live.fr")
                                                                            ->setTelephone("0102030405")
                                                                            ->setAdresse("11 rue de Paris, Lyon")
                                                                            ->setPassword("mdp")
                                                                )
                                        ->setRendezVousPraticien((new Praticien)->setNom("Dr Swaiglowdaski")
                                                                                ->setPrenom("Yunislas")
                                                                                ->setEmail("dr.Swai@live.fr")
                                                                                ->setPassword("mdp")
                                                                                ->setTelephone("0102030405")
                                                                                ->setSpecialite("Rhumatologie")
                                                                )
                                        ->setDateAndHeure(new \DateTime("2020-01-01"));
                
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($rendezVous);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }
    
    protected function tearDown() :void {
        // $this->loadFixtures([AppFixtures::class]);
    }
}