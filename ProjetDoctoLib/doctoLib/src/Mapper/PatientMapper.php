<?php

namespace App\Mapper;


use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Entity\RendezVous;

class PatientMapper {

    public function transformePatientDTOToPatientEntity(PatientDTO $patientDTO, Patient $patient, array $rendezVous){
        // $patient->setId($patientDTO->getId());
        $patient->setNom($patientDTO->getNom());
        $patient->setPrenom($patientDTO->getPrenom());
        $patient->setEmail($patientDTO->getEmail());
        $patient->setPassword($patientDTO->getPassword());
        $patient->setTelephone($patientDTO->getTelephone());
        $patient->setAdresse($patientDTO->getAdresse());
        foreach($rendezVous as $rdv){
            $patient->addRendezVouse($rdv);
        }
        return $patient;
    }

    public function transformePatientEntityToPatientDTO(Patient $patient){ 
        $rdvs = $patient->getRendezVouses();
        $idsRdvs[]=1;
            foreach($rdvs as $rdv){
                $idsRdvs[]=$rdv->getId();
            };

        $patientDTO = new PatientDTO();
        $patientDTO->setId($patient->getId());
        $patientDTO->setNom($patient->getNom());
        $patientDTO->setPrenom($patient->getPrenom());
        $patientDTO->setEmail($patient->getEmail());
        $patientDTO->setPassword($patient->getPassword());
        $patientDTO->setTelephone($patient->getTelephone());
        $patientDTO->setAdresse($patient->getAdresse());
        $patientDTO->setRendezVouses($idsRdvs);        
        return $patientDTO;
    }
}

