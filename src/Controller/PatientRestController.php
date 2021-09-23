<?php

namespace App\Controller;

use Exception;
use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use OpenApi\Annotations as OA;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exceptions\PatientServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @OA\Info(
 *      description="Patient Management",
 *      version="V1",
 *      title="Patient Management"
 * )
 */
class PatientRestController extends AbstractController
{
    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE = "/patients/{id}";

    private $patientService;
    private $entityManager;
    private $patientMapper;

    public function __construct(PatientService $patientService, 
                                EntityManagerInterface $entityManager,
                                PatientMapper $patientMapper){
        $this->patientService =$patientService;
        $this->entityManager = $entityManager;
        $this->patientMapper = $patientMapper;
    }

    /**
     * 
     * @OA\Get(
     *     path="/patients",
     *     tags={"patients"},
     *     summary="liste des patientDTO",
     *     description="Retourne la liste des patientDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Operation ", 
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Patient non trouvé",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * @Get(PatientRestController::URI_PATIENT_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $patients = $this->patientService->searchAll();
        } catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patients){
            return View::create($patients, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($patients, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/patients/{patientId}",
     *     tags={"patients"},
     *     summary="Supprimer patient",
     *     @OA\Parameter(
     *         name="api_key",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="l'id du patient pour supprimer",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération reussi", 
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Patient non trouvé",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Patient $patient){
        try {
            $this->patientService->delete($patient);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(Exception $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     tags={"patients"},
     *     summary="Créer une patient",
     *     description="creation d'un patient",
     *     @OA\Response(
     *         response=405,
     *         description="Entré valide"
     *     ),
     *  @OA\Response(
     *         response=201,
     *         description="patient inséré avec success"
     *     ),
     *     @OA\RequestBody(
     *         description="PatientDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     )
     * )
     * 
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDTO", converter="fos_rest.request_body")
     * @return void
     */
    public function create(PatientDTO $patientDTO){
        try {
            $this->patientService->persist(new Patient(), $patientDTO);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/patients/{patientId}",
     *     tags={"patients"},
     *     summary="modification du patient selon id",
     *     description="modification du patient",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="id du patient à modifier",
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
     *         description="patient non trouvé"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour de l'adresse",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     )
     * )
     * 
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @ParamConverter("patientDTO", converter="fos_rest.request_body")
     * @param patientDTO $patientDTO
     * @return void
     */
    public function update(Patient $patient, PatientDTO $patientDTO){
        try {
            $this->patientService->persist($patient, $patientDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
 * @OA\Get(
     *     path="/patiens/{patientId}",
     *     tags={"patients"},
     *     summary="Trouve un patient par ID",
     *     description="Retourne un seul patient",
     *     operationId="getpatientById",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="Id du patient",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operation réussi",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PatientDTO"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid id"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="patient non trouvé"
     *     ),
     * )
     * 
     * @Get(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $patientDTO = $this->patientService->searchById($id);
        }catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patientDTO){
            return View::create($patientDTO, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
