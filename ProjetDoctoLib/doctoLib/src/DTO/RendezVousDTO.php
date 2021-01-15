<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

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
     * @OA\Property(
     *      type="PatientDTO",
     *      description="",
     *      type="array",
     *      items= {"type"="object"}
     * )
     *
     * @var array 
     */
    private $rendezVousPatient;

    /**
     * @OA\Property(
     *      type="PraticienDTO",
     *      description="",
     *      type="array",
     *      items= {"type"="object"}
     * )
     *
     * @var array
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

    public function getRendezVousPatient(): ?array
    {
        return $this->rendezVousPatient;
    }

    public function setRendezVousPatient(?array $rendezVousPatient): self
    {
        $this->rendezVousPatient = $rendezVousPatient;
        return $this;
    }

    public function getRendezVousPraticien(): ?array
    {
        return $this->rendezVousPraticien;
    }

    public function setRendezVousPraticien(?array $rendezVousPraticien): self
    {
        $this->rendezVousPraticien = $rendezVousPraticien;
        return $this;
    }
}
