<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Entity\Brand;
use App\Form\BrandType;

/**
 * Brand controller
 * @Route("/api/", name="api_")
 */
class BrandController extends FOSRestController {
  /** 
   * Lists all Brands
   * @Rest\Get("brands")
   * 
   * @return Response
   */
  public function getBrandAction() {
    $repository = $this->getDoctrine()->getRepository(Brand::class);
    $brands = $repository->findAll();

    return $this->handleView($this->view($brands));
  }

  /** 
   * Create Brand
   * @Rest\Post("brand")
   * 
   * @return Response
   */
  public function postBrandAction(Request $request) {
    $brand = new Brand();
    $form = $this->createForm(BrandType::class, $brand);

    $data = json_decode($request->getContent(), true);
    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($brand);
      $em->flush();

      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    } 

    return $this->handleView($this->view($form->getErrors()));
  }
}