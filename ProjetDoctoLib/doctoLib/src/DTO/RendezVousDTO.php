<?php

namespace App\DTO;

use App\Entity\Patient;
use App\Entity\Praticien;

class RendezVousDTO
{
    private $id;
    private $dateAndHeure;
    private $rendezVousPatient;
    private $rendezVousPraticien;

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAndHeure(): ?\DateTimeInterface
    {
        return $this->dateAndHeure;
    }

    public function setDateAndHeure(\DateTimeInterface $dateAndHeure): self
    {
        $this->dateAndHeure = $dateAndHeure;
        return $this;
    }

    public function getRendezVousPatient(): ?PatientDTO
    {
        return $this->rendezVousPatient;
    }

    public function setRendezVousPatient(?PatientDTO $rendezVousPatient): self
    {
        $this->rendezVousPatient = $rendezVousPatient;
        return $this;
    }

    public function getRendezVousPraticien(): ?PraticienDTO
    {
        return $this->rendezVousPraticien;
    }

    public function setRendezVousPraticien(?PraticienDTO $rendezVousPraticien): self
    {
        $this->rendezVousPraticien = $rendezVousPraticien;
        return $this;
    }
}
