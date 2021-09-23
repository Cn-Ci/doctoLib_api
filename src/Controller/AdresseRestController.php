<?php

namespace App\Controller;

use Exception;
use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Mapper\AdresseMapper;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
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

/**
 * @OA\Info(
 *      description="Adresse Management",
 *      version="V1",
 *      title="Adresse Management"
 * )
 */
class AdresseRestController extends AbstractFOSRestController
{
    const URI_ADRESSE_COLLECTION = "/adresses";
    const URI_ADRESSE_INSTANCE = "/adresses/{id}";

    private $adresseService;
    private $entityManager;

    public function __construct(AdresseService $adresseService, 
                                EntityManagerInterface $entityManager,
                                AdresseMapper $adresseMapper){
        $this->adresseService =$adresseService;
        $this->entityManager = $entityManager;
        $this->adresseMapper = $adresseMapper;
    }

    /**
     * @OA\Get(
     *     path="/adresses",
     *     tags={"adresses"},
     *     summary="liste des AdresseDTO",
     *     description="retourne la liste des AdresseDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi", 
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Adresse non trouvée",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
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
     * @OA\Delete(
     *     path="/adresses/{adresseId}",
     *     tags={"adresses"},
     *     summary="Supprimer une adresse",
     *     description="Suprime une adresseDTO",
     *     @OA\Parameter(
     *         name="api_key",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="adresseId",
     *         in="path",
     *         description="Id de l'adresse pour supprimer",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi", 
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Adresse non trouvée",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
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
     * @OA\Post(
     *     path="/adresses",
     *     tags={"adresses"},
     *     summary="Créer une adresse",
     *     description="creation de l'adresse",
     *     @OA\Response(
     *         response=405,
     *         description="Entrée invalide"
     *     ),
     *  @OA\Response(
     *         response=201,
     *         description="Adresse inséré avec succès"
     *     ),
     *     @OA\RequestBody(
     *         description="ProduitDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *     )
     * )
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
     * @OA\Put(
     *     path="/adresses/{adresseId}",
     *     tags={"adresses"},
     *     summary="modification de l'adresse selon id",
     *     description="modification de l'adresse",
     *     @OA\Parameter(
     *         name="adresseId",
     *         in="path",
     *         description="id de l'adresse à modifier",
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
     *         description="Adresse non trouvée"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour de l'adresse",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *     )
     * )
     * 
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
     * @OA\Get(
     *     path="/adresses/{adresseId}",
     *     tags={"adresses"},
     *     summary="Trouve l'adresse par l'Id",
     *     description="Retourne une seule adresse",
     *     operationId="getadressesById",
     *     @OA\Parameter(
     *         name="adresseId",
     *         in="path",
     *         description="l'id de ladresse ",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussi",
     *         @OA\JsonContent(ref="#/components/schemas/AdresseDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/AdresseDTO"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Id est introuvable"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse non trouvée"
     *     ),
     * )
     * 
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