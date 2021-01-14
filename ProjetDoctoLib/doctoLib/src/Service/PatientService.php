<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use App\Repository\PatientRepository;
use App\Service\Exceptions\PatientServiceException;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\EntityManagerInterface;

class PatientService {

    private $repository;
    private $entityManager;
    private $patientMapper;

    public function __construct(PatientRepository $repo, EntityManagerInterface $entityManager, PatientMapper $patientMapper){
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->patientMapper = $patientMapper;
    }

    public function searchAll(){
        try {
            $patients = $this->repository->findAll();
            $patientDTOs = [];
            foreach ($patients as $patient) {
                $patientDTOs[] = $this->patientMapper->transformePatientEntityToPatientDTO($patient);
            }
            return $patientDTOs;
        }catch (DriverException $e){
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
        
    }

    public function delete(Patient $patient){
        try {
            $this->entityManager->remove($patient);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(Patient $patient, PatientDTO $patientDTO){
        try{
            // if($PatientDTO->getId()){
            //     // Cas de modification d'une Patient
            //     $Patient = $this->repository->find($PatientDTO->getId());
            // } else {
            //     // Cas de création d'une nouvelle Patient
            //     $Patient = new Patient();
            // }
            $adresse = $this->adresseRepository->find($praticienDTO->getRendezVouses());
            $patient = $this->patientMapper->transformePatientDTOToPatientEntity($patientDTO, $patient);
            $this->entityManager->persist($patient);
            $this->entityManager->flush();
        } catch(DriverException $e){
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id){
        try {
            $patient = $this->repository->find($id);
            return $this->patientMapper->transformePatientEntityToPatientDto($patient);
        } catch(DriverException $e){
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

}
