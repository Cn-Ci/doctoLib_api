<?php

namespace App\Service;

use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Mapper\PraticienMapper;
use App\Repository\AdresseRepository;
use App\Repository\PraticienRepository;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exceptions\PraticienServiceException;

class PraticienService {

    private $repository;
    private $entityManager;
    private $praticienMapper;
    private $rendezVousRepository;

    public function __construct(PraticienRepository $repo, EntityManagerInterface $entityManager, PraticienMapper $praticienMapper, AdresseRepository $adresseRepo, RendezVousRepository $rendezVousRepository){
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->praticienMapper = $praticienMapper;
        $this->adresseRepository = $adresseRepo;
        $this->rendezVousRepository = $rendezVousRepository;
    }

    public function searchAll(){
        try {
            $praticiens = $this->repository->findAll();
            $praticienDTOs = [];
            foreach ($praticiens as $praticien) {
                $praticienDTOs[] = $this->praticienMapper->transformePraticienEntityToPraticienDTO($praticien);
            }
            return $praticienDTOs;
        }catch (DriverException $e){
            throw new PraticienServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
        
    }

    public function delete(Praticien $praticien){
        try {
            $this->entityManager->remove($praticien);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new PraticienServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(Praticien $praticien, PraticienDTO $praticienDTO){
        try{
            // if($PraticienDTO->getId()){
            //     // Cas de modification d'une Praticien
            //     $Praticien = $this->repository->find($PraticienDTO->getId());
            // } else {
            //     // Cas de création d'une nouvelle Praticien
            //     $Praticien = new Praticien();
            // }

            $rendezVousIds[]=$praticienDTO->getRendezVouses();
            foreach ($rendezVousIds as $rendezVousId){
                foreach($rendezVousId as $rdvId){
                    $rendezVouss[]=$this->rendezVousRepository->find($rdvId);
                }
            }

            $adresse = $this->adresseRepository->find($praticienDTO->getRendezVouses());
            $praticien = $this->praticienMapper->transformePraticienDTOToPraticienEntity($praticienDTO, $praticien, $adresse, $rendezVouss);
            $this->entityManager->persist($praticien);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new PraticienServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id){
        try {
            $praticien = $this->repository->find($id);
            return $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
        } catch(DriverException $e){
            throw new PraticienServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

}
