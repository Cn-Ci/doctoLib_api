<?php

namespace App\Controller;

use Exception;
use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Mapper\AdresseMapper;
use FOS\RestBundle\View\View;
use App\Service\AdresseService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exceptions\AdresseServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AdresseRestController extends AbstractFOSRestController
{
    const URI_ADRESSE_COLLECTION = "/adresses";
    const URI_ADRESSE_INSTANCE = "/adresses/{id}";

    private $adresseService;
    private $entityManager;
    private $adresseMapper;

    public function __construct(AdresseService $adresseService, 
                                EntityManagerInterface $entityManager,
                                AdresseMapper $adresseMapper){
        $this->adresseService =$adresseService;
        $this->entityManager = $entityManager;
        $this->adresseMapper = $adresseMapper;
    }

    /**
     * @Get(AdresseRestController::URI_ADRESSE_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $adresses = $this->adresseService->searchAll();
        } catch(AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($adresses){
            return View::create($adresses, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($adresses, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Delete(AdresseRestController::URI_ADRESSE_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Adresse $adresse){
        try {
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(Exception $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * 
     * @Post(AdresseRestController::URI_ADRESSE_COLLECTION)
     * @ParamConverter("adresseDTO", converter="fos_rest.request_body")
     * @return void
     */
    public function create(AdresseDTO $adresseDTO){
        try {
            $this->adresseService->persist(new Adresse(), $adresseDTO);

            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

        /**
     * @Put(AdresseRestController::URI_ADRESSE_INSTANCE)
     * @ParamConverter("adresseDTO", converter="fos_rest.request_body")
     * @param AdresseDTO $adresseDTO
     * @return void
     */
    public function update(Adresse $adresse, AdresseDTO $adresseDTO){
        try {
            $this->adresseService->persist($adresse, $adresseDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(AdresseRestController::URI_ADRESSE_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $adresseDTO = $this->adresseService->searchById($id);
        }catch (AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($adresseDTO){
            return View::create($adresseDTO, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}