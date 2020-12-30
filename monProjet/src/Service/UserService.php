<?php 

namespace App\Service;

use ProduitExcept;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController {


    private $userRepository; 
    private $userManager;

    function __construct(UserRepository $repo, EntityManagerInterface $manager)
    {
        $this->userRepository = $repo;
        $this->userManager = $manager;
    }

    function searchAll() 
    {
        try {
            $user = $this->userRepository->findAll();    
        } catch (\DriverException $e) {
            throw new ProduitException ("un pb est survenu", $e);
        } 
        return $user; 
    }
}