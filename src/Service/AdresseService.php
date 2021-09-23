<?php

namespace App\Service;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Mapper\AdresseMapper;
use App\Repository\AdresseRepository;
use App\Repository\PraticienRepository;
use App\Service\Exceptions\AdresseServiceException;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\EntityManagerInterface;

class AdresseService {

    private $repository;
    private $entityManager;
    private $adresseMapper;
    private $praticienRepository;

    public function __construct(AdresseRepository $repo, EntityManagerInterface $entityManager, AdresseMapper $mapper, PraticienRepository $praticienRepository){
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->adresseMapper = $mapper;
        $this->praticienRepository = $praticienRepository;
    }

    public function searchAll(){
        try {
            $adresses = $this->repository->findAll();
            $adresseDTOs = [];
            foreach ($adresses as $adresse) {
                $adresseDTOs[] = $this->adresseMapper->transformeAdresseEntityToAdresseDTO($adresse);
            }
            return $adresseDTOs;
        }catch (DriverException $e){
            throw new AdresseServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        } 
    }

    public function delete(Adresse $adresse){
        try {
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new AdresseServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist( Adresse $adresse, AdresseDTO $adresseDTO){
        try{
            // if($adresseDTO->getId()){
            //     // Cas de modification d'une adresse
            //     $adresse = $this->repository->find($adresseDTO->getId());
            // } else {
            //     // Cas de création d'une nouvelle adresse
            //     $adresse = new Adresse();
            // }
            $praticiens=$adresseDTO->getPraticiens();
            $praticien = [];
            foreach($praticiens as $praticienKey => $praticienValue){
                $praticien[]=$this->praticienRepository->findOneby(['id' => $praticienValue]);
            }
         
            $adresse = $this->adresseMapper->transformeAdresseDtoToAdresseEntity($adresseDTO, $adresse, $praticien);
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new AdresseServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id){
        try {
            $adresse = $this->repository->find($id);
            return $this->adresseMapper->transformeAdresseEntityToAdresseDto($adresse);
        } catch(DriverException $e){
            throw new AdresseServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

}
