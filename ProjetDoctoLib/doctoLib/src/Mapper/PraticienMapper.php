<?php

namespace App\Mapper;

use App\Entity\Adresse;
use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Mapper\AdresseMapper;

class PraticienMapper {
    private $adresseMapper;

    public function __construct(AdresseMapper $adresseMapper)
    {
        $this->adresseMapper = $adresseMapper;
    }

    public function transformePraticienDTOToPraticienEntity(PraticienDTO $praticienDTO, Praticien $praticien, Adresse $adresse){
        // $praticien->setId($praticienDTO->getId());
        $praticien->setNom($praticienDTO->getNom());
        $praticien->setPrenom($praticienDTO->getPrenom());
        $praticien->setEmail($praticienDTO->getEmail());
        $praticien->setPassword($praticienDTO->getPassword());
        $praticien->setSpecialite($praticienDTO->getSpecialite());
        $praticien->setTelephone($praticienDTO->getTelephone());
        $praticien->setAdresse($adresse);
        return $praticien;
    }

    public function transformePraticienEntityToPraticienDTO(praticien $praticien){
        $praticienDTO = new praticienDTO();
        $praticienDTO->setId($praticien->getId());
        $praticienDTO->setNom($praticien->getNom());
        $praticienDTO->setPrenom($praticien->getPrenom());
        $praticienDTO->setEmail($praticien->getEmail());
        $praticienDTO->setPassword($praticien->getPassword());
        $praticienDTO->setSpecialite($praticien->getSpecialite());
        $praticienDTO->setTelephone($praticien->getTelephone());
        $praticienDTO->setAdresse($this->adresseMapper->transformeAdresseEntityToAdresseDTO($praticien->getAdresse()));
        return $praticienDTO;
    }
}