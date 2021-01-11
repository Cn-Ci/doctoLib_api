<?php

namespace App\Mapper;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;

class AdresseMapper {

    public function transformeAdresseDTOToAdresseEntity(AdresseDTO $adresseDTO, Adresse $adresse){
        // $adresse->setId($adresseDTO->getId());
        $adresse->setNumeroVoie($adresseDTO->getNumeroVoie());
        $adresse->setRue($adresseDTO->getRue());
        $adresse->setCodePostal($adresseDTO->getCodePostal());
        $adresse->setVille($adresseDTO->getVille());
        return $adresse;
    }

    public function transformeAdresseEntityToAdresseDTO(Adresse $adresse){
        $adresseDTO = new AdresseDTO();
        $adresseDTO->setId($adresse->getId());
        $adresseDTO->setNumeroVoie($adresse->getNumeroVoie());
        $adresseDTO->setRue($adresse->getRue());
        $adresseDTO->setCodePostal($adresse->getCodePostal());
        $adresseDTO->setVille($adresse->getVille());
        return $adresseDTO;
    }
}