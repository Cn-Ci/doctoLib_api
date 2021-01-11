<?php

namespace App\DTO;

class AdresseDTO
{
    private $id;
    private $numeroVoie;
    private $rue;
    private $codePostal;
    private $ville;
    private $praticiens;

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroVoie(): ?int
    {
        return $this->numeroVoie;
    }

    public function setNumeroVoie(?int $numeroVoie): self
    {
        $this->numeroVoie = $numeroVoie;
        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;
        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): self
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

}
