<?php

namespace App\Mapper;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Entity\Praticien;

class AdresseMapper {

    public function transformeAdresseDTOToAdresseEntity(AdresseDTO $adresseDTO, Adresse $adresse, Praticien $praticiens){
        // $adresse->setId($adresseDTO->getId());
        $adresse->setNumeroVoie($adresseDTO->getNumeroVoie());
        $adresse->setRue($adresseDTO->getRue());
        $adresse->setCodePostal($adresseDTO->getCodePostal());
        $adresse->setVille($adresseDTO->getVille());
        foreach($praticiens as $praticien){
            $adresse->addPraticien($praticien);
        }
        return $adresse;
    }

    public function transformeAdresseEntityToAdresseDTO(Adresse $adresse){
        $praticiens = $adresse->getPraticiens();
        $praticiensIds[]=0;
            foreach($praticiens as $praticien){
                $praticiensIds[]=$praticien->getId();
            };

        $adresseDTO = new AdresseDTO();
        $adresseDTO->setId($adresse->getId());
        $adresseDTO->setNumeroVoie($adresse->getNumeroVoie());
        $adresseDTO->setRue($adresse->getRue());
        $adresseDTO->setCodePostal($adresse->getCodePostal());
        $adresseDTO->setVille($adresse->getVille());
        $adresseDTO->setPraticiens($praticiensIds);
        return $adresseDTO;
    }
}

//** GET    => OK */
//** PUT    => "The identifier id is missing for a query of App\\Entity\\Praticien" */
//** POST   => "The identifier id is missing for a query of App\\Entity\\Praticien" */
//** DELETE => OK */