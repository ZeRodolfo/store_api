<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Lib\Paginator;

/** 
 * Category controller
 * @Route("/api/", name="api_")
 */
class CategoryController extends FOSRestController {
  /**
   * List all Categories
   * @Rest\Get("categories")
   * 
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    $registry = $this->getDoctrine();
    $repository = new CategoryRepository($registry);
    $categories = $repository->findAll('json');

    $paginator = new Paginator($categories, 5);
    $pagination = $paginator->setCurrentPage(1)->paginate();

    return new JsonResponse($pagination);
  }

  /** 
   * Show Category
   * @Rest\Get("categories/{id}")
   * 
   * @return JsonResponse
   */
  public function showAction(Category $category): JsonResponse
  {
    return new JsonResponse($category->toJSON());
  }

  /** 
   * Create Category
   * @Rest\Post("category")
   * 
   * @return JsonResponse
   */
  public function createAction(ValidatorInterface $validator, Request $request): JsonResponse
  {
    $data = json_decode($request->getContent());
    $user = $this->getUser();

    $registry = $this->getDoctrine();
    $repository = new CategoryRepository($registry);

    $parent = NULL;
    if (isset($data->parent)) {
      $parent = $repository->find($data->parent);
    }

    $category = new Category($data);
    $category->setParent($parent);
    $category->setUserCreated($user);
    $category->setUserUpdated($user);

    $errors = $validator->validate($category);

    if (count($errors) > 0) {
      $dataErrors = [];
      foreach($errors as $error){
        // Do stuff with:
        //   $error->getPropertyPath() : the field that caused the error
        //   $error->getMessage() : the error message
        $dataErrors[$error->getPropertyPath()] = $error->getMessage();
      }

      return new JsonResponse($dataErrors);
    }
          
    $status = $repository->save($category);
    $json = $repository->toJSON();

    $dataResponse = [
      'status' => $status,
      'entity' => $json
    ];

    return new JsonResponse($dataResponse);
  }
}