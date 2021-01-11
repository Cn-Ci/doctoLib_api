<?php

namespace App\Mapper;


use App\DTO\PatientDTO;
use App\Entity\Patient;

class PatientMapper {

    public function transformePatientDTOToPatientEntity(PatientDTO $patientDTO, Patient $patient){
        // $patient->setId($patientDTO->getId());
        $patient->setNom($patientDTO->getNom());
        $patient->setPrenom($patientDTO->getPrenom());
        $patient->setEmail($patientDTO->getEmail());
        $patient->setPassword($patientDTO->getPassword());
        $patient->setTelephone($patientDTO->getTelephone());
        $patient->setAdresse($patientDTO->getAdresse());
        return $patient;
    }

    public function transformePatientEntityToPatientDTO(Patient $patient){
        $patientDTO = new PatientDTO();
        $patientDTO->setId($patient->getId());
        $patientDTO->setNom($patient->getNom());
        $patientDTO->setPrenom($patient->getPrenom());
        $patientDTO->setEmail($patient->getEmail());
        $patientDTO->setPassword($patient->getPassword());
        $patientDTO->setTelephone($patient->getTelephone());
        $patientDTO->setAdresse($patient->getAdresse());
        return $patientDTO;
    }
}