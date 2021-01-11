<?php

namespace App\Controller;

use Exception;
use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exceptions\PatientServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
