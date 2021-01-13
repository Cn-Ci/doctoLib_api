<?php

namespace App\DTO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @OA\Schema()
 */
class RendezVousDTO
{
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     default="2017-02-02 18:31:45",
     *     format="datetime",
     *     description="heure et date du rendezVous",
     *     title="heure et date du rendezVous",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $dateAndHeure;

    /**
     * @OA\Property(type="PatientDTO")
     *
     * @var int 
     */
    private $rendezVousPatient;

    /**
      * @OA\Property(
     *     description="heure et date du rendezVous",
     *     title="heure et date du rendezVous",
     *     type=array
     * )
     *
     * @var int
     */
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
