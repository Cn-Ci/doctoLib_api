<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AdresseDTO
{
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $numeroVoie;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $rue;

    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $codePostal;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $ville;

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

    public function getPraticiens() :array
    {
        return $this->praticiens;
    }

    public function setPraticiens(array $praticiens)
    {
        $this->praticiens = $praticiens;
        return $this;
    }
}
