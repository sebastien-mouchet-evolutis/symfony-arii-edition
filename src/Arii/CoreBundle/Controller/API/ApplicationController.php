<?php
namespace Arii\CoreBundle\Controller\API;

use Arii\CoreBundle\Entity\Application;
use Arii\CoreBundle\Exception\ResourceValidationException;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TimeInc\SwaggerBundle\Swagger\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;


/**
 * 
 * @SWG\Parameter(
 *   parameter="application_id_in_path_required",
 *   name="application_id",
 *   description="The ID of the application",
 *   type="integer",
 *   format="int64",
 *   in="path",
 *   required=true
 * )
 *
 * @SWG\Parameter(
 *   parameter="application_in_body",
 *   in="body",
 *   name="application",
 *   @SWG\Schema(ref="#/definitions/Application")
 * )
 *  
 * @SWG\Path(
 *   path="/applications/{application_id}",
 *   @SWG\Parameter(ref="#/parameters/application_id_in_path_required")
 * )
 * 
 * @SWG\Response(
 *   response="application",
 *   description="All information about an application",
 *   @SWG\Schema(ref="#/definitions/Application")
 * )
 * 
 * @Rest\View(StatusCode = 200)
 */

class ApplicationController extends FOSRestController
{
    /**
     * @SWG\Get(
     *   path="/applications",
     *   summary="list applications",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with applications"
     *   )
     * )
     */
    public function searchAction()
    {
        $Applications = $this->getDoctrine()->getRepository('AriiCoreBundle:Application')->findAll();        
        return $Applications;
    }

    /**
     * @SWG\Post(
     *     path="/applications",
     *     summary="Add a new application.",
     *     description="Create a new application.",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(ref="#/parameters/application_in_body"),
     *     @SWG\Response(
     *          response=201,
     *          description="All information about an application",
     *          @SWG\Schema(ref="#/definitions/Application")
     *     )
     * )
     * @ParamConverter(
     *      "Application", 
     *      converter="fos_rest.request_body",
     *      options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     *
     * @Rest\View(StatusCode = 201)
     */
    public function createAction(Application $Application, ConstraintViolationList $violations)
    {      
        if (count($violations)) {
            $Message=[];
            foreach ($violations as $violation) {
                array_push($Message,[
                    // Field translated according the i18n/l10n and displayable to the user
                    "display" => $violation->getMessage(),
                    // ValidationCode used to defined the label
                    "code" => $violation->getMessageTemplate(),
                    // Concerned field(s)
                    "fields" => array($violation->getPropertyPath())
                ]);
            }
            return array("validations" => $Message );
            return ResourceValidationException($message);
        }
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($Application);
        $em->flush();

        return $Application;
    }
    
    /**
     * @SWG\Get(
     *   path="/applications/{application_id}",
     *   summary="Affiche les informations pour une application identifiée par son id.",
     *   @SWG\Response(
     *          response=200,
     *          description="All information about an application",
     *          @SWG\Schema(ref="#/definitions/Application")
     *   )
     * )
     */    
    public function retrieveAction($id)
    {
        $Application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);
        return $Application;
    }

    /**
     * @SWG\Put(
     *     path="/applications/{application_id}",
     *     summary="Add a new application.",
     *     description="ERIC",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Application object that needs to be added to the repository.",
     *         required=true,
     *         @SWG\Schema(
     *              @SWG\Property(
     *                  property="name",
     *                  type="string",
     *                  maximum=64
     *              ),
     *              @SWG\Property(
     *                  property="description",
     *                  type="string"
     *              )     
     *         ),
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Example extended response",
     *          ref="$/responses/Json",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Application"
     *              )
     *          )
     *     )
     * )
     */
    public function updateAction($id)
    {
        $Application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);
        return $Application;        
    }

    /**
     * @SWG\Delete(
     *   path="/applications/{application_id}",
     *   summary="Delete an application",
     *   @SWG\Response(
     *     response=200,
     *     description="L'application"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="une erreur ""bizarre"""
     *   )
     * )
     */    
    public function deleteAction($id)
    {
        $Application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);
        return $Application;        
    }
    
}
