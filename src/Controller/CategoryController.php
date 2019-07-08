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
}