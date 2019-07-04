<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Brand;
use App\Repository\BrandRepository;

/**
 * Brand controller
 * @Route("/api/", name="api_")
 * @IsGranted("ROLE_ADMIN")
 */
class BrandController extends FOSRestController {
  /** 
   * Lists all Brands
   * @Rest\Get("brands")
   * 
   * @return JsonResponse
   */
  public function indexAction(): JsonResponse 
  {
    $registry = $this->getDoctrine();
    $repository = new BrandRepository($registry);
    $brands = $repository->findAll('json');

    return new JsonResponse($brands);
  }

  /** 
   * Show Brand
   * @Rest\Get("brand/{id}")
   * 
   * @return JsonResponse
   */
  public function showAction(Brand $brand): JsonResponse 
  {
    return new JsonResponse($brand->toJSON());
  }

  /** 
   * Create Brand
   * @Rest\Post("brand")
   * 
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $data = json_decode($request->getContent());
    $user = $this->getUser();

    $brand = new Brand($data);
    $brand->setUserCreated($user);
    $brand->setUserUpdated($user);

    $registry = $this->getDoctrine();
    $repository = new BrandRepository($registry);
          
    $status = $repository->save($brand);
    $json = $repository->toJSON();

    $dataResponse = [
      'status' => $status,
      'entity' => $json
    ];

    return new JsonResponse($dataResponse);
  }

  /** 
   * Update Brand
   * @Rest\Put("brand/{id}")
   * 
   * @return JsonResponse
   */
  public function updateAction(Brand $brand, Request $request) {
    $data = json_decode($request->getContent(), true);
    
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($brand);
    $em->flush();

    $response = new JsonResponse(['oi'], 200);

    return $response;
  }

  /** 
   * Delete Brand
   * @Rest\Delete("brand/{id}")
   * 
   * @return JsonResponse
   */
  public function deleteAction(Request $request, Brand $brand): JsonResponse 
  {
    $dataResponse = [
      'status' => true,
      'mensage' => "Marca excluída com sucesso."
    ];

    if ($brand === null) {
      $dataResponse = [
        'status' => false,
        'mensage' => "Não foi possível excluir, pois esta Marca já não se encontra mais no sistema."
      ];
    }
    
    $em = $this->getDoctrine()->getManager();

    try {
      $em->remove($brand);
      $em->flush();
    } catch (Exception $ex) {
      $dataResponse = [
        'status' => false,
        'mensage' => $ex->getMessage()
      ];
    }

    return new JsonResponse($dataResponse);
  }
}