<?php

namespace App\Mapper;

use App\Entity\Patient;
use App\Entity\Praticien;
use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\PatientMapper;
use App\Mapper\PraticienMapper;

class RendezVousMapper {
    private $patientMapper;
    private $praticienMapper;

    public function __construct(PatientMapper $patientMapper, PraticienMapper $praticienMapper)
    {
        $this->patientMapper = $patientMapper;
        $this->praticienMapper = $praticienMapper; 
    }

    public function transformeRendezVousDTOToRendezVousEntity(RendezVousDTO $rendezVousDTO, RendezVous $rendezVous, Patient $patient, Praticien $praticien){
        // $rendezVous->setId($rendezVousDTO->getId());
        $rendezVous->setDateAndHeure($rendezVousDTO->getDateAndHeure());
        $rendezVous->setRendezVousPatient($patient);
        $rendezVous->setRendezVousPraticien($praticien);
        return $rendezVous;
    }

    public function transformeRendezVousEntityToRendezVousDTO(RendezVous $rendezVous){
        $rendezVousDTO = new rendezVousDTO();
        $rendezVousDTO->setId($rendezVous->getId());
        $rendezVousDTO->setDateAndHeure($rendezVous->getDateAndHeure());
        $rendezVousDTO->setRendezVousPatient($this->patientMapper->transformePatientEntityToPatientDTO($rendezVous->getRendezVousPatient()));
        $rendezVousDTO->setRendezVousPraticien($this->praticienMapper->transformePraticienEntityToPraticienDTO($rendezVous->getRendezVousPraticien()));
        return $rendezVousDTO;
    }
}