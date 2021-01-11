<?php

namespace App\Controller;

use Exception;
use App\Mapper\PraticienMapper;
use App\Service\PraticienService;
use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exceptions\PraticienServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PraticienRestController extends AbstractController
{
    const URI_PRATICIEN_COLLECTION = "/praticiens";
    const URI_PRATICIEN_INSTANCE = "/praticiens/{id}";

    private $praticienService;

    public function __construct(PraticienService $praticienService, 
                                EntityManagerInterface $entityManager,
                                PraticienMapper $praticienMapper){
        $this->praticienService =$praticienService;
        $this->entityManager = $entityManager;
        $this->praticienMapper = $praticienMapper;
    }

    /**
     * @Get(PraticienRestController::URI_PRATICIEN_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $praticiens = $this->praticienService->searchAll();
        } catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticiens){
            return View::create($praticiens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($praticiens, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Delete(PraticienRestController::URI_PRATICIEN_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Praticien $praticien){
        try {
            $this->praticienService->delete($praticien);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
    
    /**
     * 
     * @Post(PraticienRestController::URI_PRATICIEN_COLLECTION)
     * @ParamConverter("praticienDTO", converter="fos_rest.request_body")
     * @return void
     */
    public function create(PraticienDTO $praticienDTO){
        try {
            $this->praticienService->persist(new Praticien(), $praticienDTO);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Put(praticienRestController::URI_PRATICIEN_INSTANCE)
     * @ParamConverter("praticienDTO", converter="fos_rest.request_body")
     * @param praticienDTO $PraticienDTO
     * @return void
     */
    public function update(Praticien $praticien, PraticienDTO $praticienDTO){
        try {
            $this->praticienService->persist($praticien, $praticienDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(praticienRestController::URI_PRATICIEN_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $praticienDTO = $this->praticienService->searchById($id);
        }catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticienDTO){
            return View::create($praticienDTO, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
