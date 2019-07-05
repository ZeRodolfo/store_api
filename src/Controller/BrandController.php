<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Lib\Paginator;

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

    $paginator = new Paginator($brands, 5);
    $pagination = $paginator->setCurrentPage(1)->paginate();

    return new JsonResponse($pagination);
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
  public function createAction(ValidatorInterface $validator, Request $request): JsonResponse
  {
    $data = json_decode($request->getContent());
    $user = $this->getUser();

    $brand = new Brand($data);
    $brand->setUserCreated($user);
    $brand->setUserUpdated($user);

    $errors = $validator->validate($brand);

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

    $registry = $this->getDoctrine();
    $repository = new BrandRepository($registry, Brand::class);
          
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
  public function updateAction(Brand $brand, ValidatorInterface $validator, Request $request) {
    $data = json_decode($request->getContent());
    $user = $this->getUser();

    $brand->load($data);
    $brand->setUserUpdated($user);

    $errors = $validator->validate($brand);

    if (count($errors) > 0) {
      $dataErrors = [];
      foreach($errors as $error){
        $dataErrors[$error->getPropertyPath()] = $error->getMessage();
      }

      return new JsonResponse($dataErrors);
    }

    $registry = $this->getDoctrine();
    $repository = new BrandRepository($registry, Brand::class);
          
    $status = $repository->save($brand);
    $json = $repository->toJSON();

    $dataResponse = [
      'status' => $status,
      'entity' => $json
    ];

    return new JsonResponse($dataResponse);
  }

  /** 
   * Delete Brand
   * @Rest\Delete("brand/{id}")
   * 
   * @return JsonResponse
   */
  public function deleteAction(Request $request, Brand $brand): JsonResponse 
  {
    $registry = $this->getDoctrine();
    $repository = new BrandRepository($registry);
    $status = $repository->delete($brand);

    if ($status) {
      $dataResponse = [
        'status' => true,
        'mensage' => "Marca excluída com sucesso."
      ];
    } else {
      $dataResponse = [
        'status' => false,
        'mensage' => "Não foi possível excluir esta Marca. " . $repository->getErrors()
      ];
    }

    return new JsonResponse($dataResponse);
  }
}