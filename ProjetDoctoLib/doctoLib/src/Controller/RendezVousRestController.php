<?php

namespace App\Controller;

use Exception;
use App\Mapper\RendezVousMapper;
use App\Service\RendezVousService;
use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exceptions\RendezVousServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RendezVousRestController extends AbstractController
{
    const URI_RENDEZVOUS_COLLECTION = "/rendezVouss";
    const URI_RENDEZVOUS_INSTANCE = "/rendezVouss/{id}";

    private $rendezVousService;

    public function __construct(RendezvousService $rendezVousService, 
                                EntityManagerInterface $entityManager,
                                RendezvousMapper $rendezVousMapper){
        $this->rendezVousService =$rendezVousService;
        $this->entityManager = $entityManager;
        $this->rendezVousMapper = $rendezVousMapper;
    }

    /**
     * @Get(RendezvousRestController::URI_RENDEZVOUS_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $rendezVouss = $this->rendezVousService->searchAll();
        } catch(RendezvousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rendezVouss){
            return View::create($rendezVouss, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($rendezVouss, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Delete(RendezvousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Rendezvous $rendezVous){
        try {
            $this->rendezVousService->delete($rendezVous);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(RendezvousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
    
    /**
     * 
     * @Post(RendezvousRestController::URI_RENDEZVOUS_COLLECTION)
     * @ParamConverter("rendezVousDTO", converter="fos_rest.request_body")
     * @return void
     */
    public function create(RendezvousDTO $rendezVousDTO){
        try {
            $this->rendezVousService->persist(new Rendezvous(), $rendezVousDTO);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (RendezvousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Put(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     * @ParamConverter("rendezVousDTO", converter="fos_rest.request_body")
     * @param rendezVousDTO $rendezVousDTO
     * @return void
     */
    public function update(RendezVous $rendezVous, RendezVousDTO $rendezVousDTO){
        try {
            $this->rendezVousService->persist($rendezVous, $rendezVousDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $rendezVousDTO = $this->rendezVousService->searchById($id);
        }catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rendezVousDTO){
            return View::create($rendezVousDTO, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
