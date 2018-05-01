<?php
namespace Arii\CoreBundle\Controller\API;

use \Arii\CoreBundle\Entity\Category;

use FOS\RestBundle\Controller\Annotations as Rest;
use TimeInc\SwaggerBundle\Swagger\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swagger\Annotations as SWG;

/**
 * 
 * @SWG\Parameter(
 *   parameter="category_id_in_path_required",
 *   name="category_id",
 *   description="The ID of the category",
 *   type="integer",
 *   format="int64",
 *   in="path",
 *   required=true
 * )
 *
 * @SWG\Parameter(
 *   parameter="category_in_body",
 *   in="body",
 *   name="category",
 *   @SWG\Schema(ref="#/definitions/Category")
 * )
 *  
 * @SWG\Path(
 *   path="/categories/{category_id}",
 *   @SWG\Parameter(ref="#/parameters/category_id_in_path_required")
 * )
 * 
 * @SWG\Response(
 *   response="category",
 *   description="All information about an category",
 *   @SWG\Schema(ref="#/definitions/Category")
 * )
 * 
 */

class CategoryController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/categories",
     *   summary="list categories",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with categories"
     *   )
     * )
     */
    public function searchAction()
    {
        $Categories = $this->getDoctrine()->getRepository('AriiCoreBundle:Category')->findAll();        
        return $Categories;
    }

    /**
     * @SWG\Post(
     *     path="/categories",
     *     summary="Add a new category.",
     *     description="Create a new category.",
     *     consumes={"category/json", "category/xml"},
     *     produces={"category/xml", "category/json"},
     *     @SWG\Parameter(ref="#/parameters/category_in_body"),
     *     @SWG\Response(
     *          response=201,
     *          description="All information about an category",
     *          @SWG\Schema(ref="#/definitions/Category")
     *     )
     * )
     * @ParamConverter("Category", converter="fos_rest.request_body")
     */
    public function createAction(Category $Category)
    {      
        $em = $this->getDoctrine()->getManager();

        $em->persist($Category);
        $em->flush();

        return $Category;
    }
    
    /**
     * @SWG\Get(
     *   path="/categories/{category_id}",
     *   summary="Affiche les informations pour une category identifiée par son id.",
     *   @SWG\Response(
     *          response=200,
     *          description="All information about an category",
     *          @SWG\Schema(ref="#/definitions/Category")
     *   )
     * )
     */    
    public function retrieveAction($id)
    {
        $Category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);
        return $Category;
    }

    /**
     * @SWG\Put(
     *     path="/categories/{category_id}",
     *     summary="Add a new category.",
     *     description="ERIC",
     *     consumes={"category/json", "category/xml"},
     *     produces={"category/xml", "category/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Category object that needs to be added to the repository.",
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
     *                  ref="#/definitions/Category"
     *              )
     *          )
     *     )
     * )
     */
    public function updateAction($id)
    {
        $Category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);
        return $Category;        
    }

    /**
     * @SWG\Delete(
     *   path="/categories/{category_id}",
     *   summary="Delete an category",
     *   @SWG\Response(
     *     response=200,
     *     description="L'category"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="une erreur ""bizarre"""
     *   )
     * )
     */    
    public function deleteAction($id)
    {
        $Category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);
        return $Category;        
    }
    
}
