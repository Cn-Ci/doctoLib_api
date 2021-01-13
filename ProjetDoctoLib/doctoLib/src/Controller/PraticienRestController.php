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


/**
 * @OA\Info(
 *      description="Praticien Management",
 *      version="V1",
 *      title="Praticien Management"
 * )
 */
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
     * @OA\Get(
     *     path="/praticiens",
     *     tags={"praticiens"},
     *     summary="listes des PraticienDTO",
     *     description="Retourne la liste des PraticienDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Operation reussi", 
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Praticien non trouvé",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
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
     * @OA\Delete(
     *     path="/praticiens/{praticienId}",
     *     tags={"praticiens"},
     *     summary="Supprimer un praticien",
     *     @OA\Parameter(
     *         name="api_key",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="l'id praticien pour delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération reussi", 
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Praticien non trouvé",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
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
     * @OA\Post(
     *     path="/praticiens",
     *     tags={"praticiens"},
     *     summary="Créer une praticien",
     *     description="creation de praticien",
     *     @OA\Response(
     *         response=405,
     *         description="Entré valid"
     *     ),
     *  @OA\Response(
     *         response=201,
     *         description="Praticien inséré avec succès"
     *     ),
     *     @OA\RequestBody(
     *         description="PraticienDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *     )
     * )
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
     * @OA\Put(
     *     path="/praticiens/{praticienId}",
     *     tags={"praticiens"},
     *     summary="modification du praticien selon id",
     *     description="modification du praticien",
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="id du praticien à modifier",
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
     *         description="praticien non trouvé"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour de l'adresse",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *     )
     * )
     * 
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
     * 
     * @OA\Get(
     *     path="/praticiens/{praticienId}",
     *     tags={"praticiens"},
     *     summary="Find praticien by ID",
     *     description="Returns a single praticien",
     *     operationId="getpraticienById",
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="ID of praticien to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PraticienDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PraticienDTO"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="praticien not found"
     *     ),
     * )
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
