<?php

namespace App\Controller;

use Exception;
use App\Mapper\RendezVousMapper;
use App\Service\RendezVousService;
use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
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

/**
 * @OA\Info(
 *      description="RendezVous Management",
 *      version="V1",
 *      title="RendezVous Management"
 * )
 */
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
     * @OA\Get(
     *     path="/rendezVous",
     *     tags={"rendezVous"},
     *     summary="liste des rendezVousDTO",
     *     description="retourne la liste des rendezVousDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi", 
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="rendezVous non trouvée",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
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
     * 
     * @OA\Delete(
     *     path="/rendezVous/{rendezVousId}",
     *     tags={"rendezVous"},
     *     summary="Supprimer une rendezVous",
     *     description="Suprime une rendezVousDTO",
     *     @OA\Parameter(
     *         name="api_key",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="rendezVousId",
     *         in="path",
     *         description="Id de rendezVous pour supprimer",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi", 
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="rendezVous non trouvée",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
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
     * @OA\Post(
     *     path="/rendezVous",
     *     tags={"rendezVous"},
     *     summary="Créer un rendezVous",
     *     description="creation d'un rendezVous",
     *     @OA\Response(
     *         response=405,
     *         description="Entrée invalide"
     *     ),
     *  @OA\Response(
     *         response=201,
     *         description="rendezVous inséré avec succès"
     *     ),
     *     @OA\RequestBody(
     *         description="RendezVousDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *     )
     * )
     * 
     * @Post(RendezvousRestController::URI_RENDEZVOUS_COLLECTION)
     * @ParamConverter("rendezVousDTO", converter="fos_rest.request_body")
     * @return void
     */
    public function create(RendezvousDTO $rendezVousDTO){
        //var_dump($rendezVousDTO);
        try {
            $this->rendezVousService->persist(new Rendezvous(), $rendezVousDTO);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (RendezvousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/rendezVous/{rendezVousId}",
     *     tags={"rendezVous"},
     *     summary="modification du rendezVous selon id",
     *     description="modification du rendezVous ",
     *     @OA\Parameter(
     *         name="rendezVousId",
     *         in="path",
     *         description="id du rendezVous à modifier",
     *         required=true,
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Modification invalide"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="RendezVous non trouvée"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour du rendezVous",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *     )
     * )
     * 
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
     * @OA\Get(
     *     path="/rendezVous/{rendezVousId}",
     *     tags={"rendezVous"},
     *     summary="Trouve le rendezVous par l'Id",
     *     description="Retourne un seul rendezVous",
     *     operationId="getRendezVousById",
     *     @OA\Parameter(
     *         name="rendezVousId",
     *         in="path",
     *         description="l'id de rendezVous",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi",
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/RendezVousDTO"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Id est introuvable"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="RendezVous non trouvée"
     *     ),
     * )
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
