<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdresseRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroVoie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'addresse est obligatoire.")
     */
    private $rue;

    /**
     * @ORM\Column(type="integer")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Praticien::class, mappedBy="adresse", cascade={"persist", "remove"})
     */
    private $praticiens;

    public function __construct()
    {
        $this->praticiens = new ArrayCollection();
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

    /**
     * @return Collection|Praticien[]
     */
    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    public function addPraticien(Praticien $praticien): self
    {
        if (!$this->praticiens->contains($praticien)) {
            $this->praticiens[] = $praticien;
            $praticien->setAdresse($this);
        }

        return $this;
    }

    public function removePraticien(Praticien $praticien): self
    {
        if ($this->praticiens->removeElement($praticien)) {
            // set the owning side to null (unless already changed)
            if ($praticien->getAdresse() === $this) {
                $praticien->setAdresse(null);
            }
        }

        return $this;
    }
}
