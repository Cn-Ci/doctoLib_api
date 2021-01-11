<?php

namespace App\DTO;

class PatientDTO {

    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $telephone;
    private $adresse;
    private $rendezVouses;

    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword() :?string
    {
        return $this->password;
    }

    public function setPassword(?string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getRendezVouses()
    {
        return $this->rendezVouses;
    }
 
    public function setRendezVouses($rendezVouses)
    {
        $this->rendezVouses = $rendezVouses;
        return $this;
    }
}
