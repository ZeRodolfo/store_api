<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Lib\Paginator;

/** 
 * Category controller
 * @Route("/api/", name="api_")
 */
class ProductController extends FOSRestController {
  /**
   * List all Products
   * @Rest\Get("products")
   * 
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    $registry = $this->getDoctrine();
    $repository = new ProductRepository($registry);
    $products = $repository->findAll('json');

    $paginator = new Paginator($products, 5);
    $pagination = $paginator->setCurrentPage(1)->paginate();

    return new JsonResponse($pagination);
  }
}