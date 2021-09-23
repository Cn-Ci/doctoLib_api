<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAndHeure;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="rendezVouses", cascade={"persist"})
     */
    private $rendezVousPatient;

    /**
     * @ORM\ManyToOne(targetEntity=Praticien::class, inversedBy="rendezVouses", cascade={"persist"})
     */
    private $rendezVousPraticien;

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

    public function getRendezVousPatient(): ?Patient
    {
        return $this->rendezVousPatient;
    }

    public function setRendezVousPatient(?Patient $rendezVousPatient): self
    {
        $this->rendezVousPatient = $rendezVousPatient;

        return $this;
    }

    public function getRendezVousPraticien(): ?Praticien
    {
        return $this->rendezVousPraticien;
    }

    public function setRendezVousPraticien(?Praticien $rendezVousPraticien): self
    {
        $this->rendezVousPraticien = $rendezVousPraticien;

        return $this;
    }
}
