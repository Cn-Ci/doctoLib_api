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

    public function transformePraticienDTOToPraticienEntity(PraticienDTO $praticienDTO, Praticien $praticien, array $adresse, array $rendezVous){
        // $praticien->setId($praticienDTO->getId());
        $praticien->setNom($praticienDTO->getNom());
        $praticien->setPrenom($praticienDTO->getPrenom());
        $praticien->setEmail($praticienDTO->getEmail());
        $praticien->setPassword($praticienDTO->getPassword());
        $praticien->setSpecialite($praticienDTO->getSpecialite());
        $praticien->setTelephone($praticienDTO->getTelephone());
        foreach($adresse as $adress){
            $praticien->setAdresse($adress);
        }
        foreach($rendezVous as $rdv){
            $praticien->addRendezVouse($rdv);
        }
        return $praticien;
    }

    public function transformePraticienEntityToPraticienDTO(praticien $praticien){
        $adresse=[ ($praticien->getAdresse())->getId(),
                    ($praticien->getAdresse())->getNumeroVoie(),
                    ($praticien->getAdresse())->getRue(),
                    ($praticien->getAdresse())->getCodePostal(),
                    ($praticien->getAdresse())->getVille()
                ];
         
        $rdvs = $praticien->getRendezVouses();
        $idsRdvs[]=1;
            foreach($rdvs as $rdv){
                $idsRdvs[]=$rdv->getId();
            };

        $praticienDTO = new praticienDTO();
        $praticienDTO->setId($praticien->getId());
        $praticienDTO->setNom($praticien->getNom());
        $praticienDTO->setPrenom($praticien->getPrenom());
        $praticienDTO->setEmail($praticien->getEmail());
        $praticienDTO->setPassword($praticien->getPassword());
        $praticienDTO->setSpecialite($praticien->getSpecialite());
        $praticienDTO->setTelephone($praticien->getTelephone());
        $praticienDTO->setAdresse($adresse);
        $praticienDTO->setRendezVouses($idsRdvs);
        return $praticienDTO;
    }
}


//** DELETE => KO */
//** RendezVous en entier */