<?php

namespace App\Service;

use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\RendezVousMapper;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use App\Repository\RendezVousRepository;
use App\Service\Exceptions\RendezVousServiceException;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\EntityManagerInterface;

class RendezVousService {

    private $repository;
    private $entityManager;
    private $rendezVousMapper;

    public function __construct(RendezVousRepository $repo, EntityManagerInterface $entityManager, RendezVousMapper $rendezVousMapper, PatientRepository $patientRepository, PraticienRepository $praticienRepository){
        $this->repository = $repo;
        $this->patientRepository = $patientRepository;
        $this->praticienRepository = $praticienRepository;
        $this->entityManager = $entityManager;
        $this->rendezVousMapper = $rendezVousMapper;
    }

    public function searchAll(){
        try {
            $rendezVouss = $this->repository->findAll();
            $rendezVousDTOs = [];
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDTOs[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDTO($rendezVous);
            }
            return $rendezVousDTOs;
        }catch (DriverException $e){
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
        
    }

    public function delete(RendezVous $rendezVous){
        try {
            $this->entityManager->remove($rendezVous);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(RendezVous $rendezVous, RendezVousDTO $rendezVousDTO){
        try{
            // if($RendezVousDTO->getId()){
            //     // Cas de modification d'une RendezVous
            //     $RendezVous = $this->repository->find($RendezVousDTO->getId());
            // } else {
            //     // Cas de création d'une nouvelle RendezVous
            //     $RendezVous = new RendezVous();
            // }
        
            $patients=$rendezVousDTO->getRendezVousPatient();
            $patient = [];
            foreach($patients as $patientRdv => $patientValue){
                $patient[]=$this->patientRepository->findOneby(['id' => $patientValue]);
            }

            $praticiens=$rendezVousDTO->getRendezVousPraticien();
            $praticien = [];
            foreach($praticiens as $praticienRdv => $praticienValue){
                $praticien[]=$this->praticienRepository->findOneby(['id' => $praticienValue]);
            }
           
        
            $rendezVous = $this->rendezVousMapper->transformeRendezVousDtoToRendezVousEntity($rendezVousDTO, $rendezVous, $patient, $praticien);
          
            $this->entityManager->persist($rendezVous);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id){
        try {
            $rendezVous = $this->repository->find($id);
            return $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
        } catch(DriverException $e){
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

}
