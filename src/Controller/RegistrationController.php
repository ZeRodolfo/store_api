<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;

use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Registration Controller
 * @Route("/registration/")
 */
class RegistrationController extends BaseController {

  private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenStorage;

  public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
      parent::__construct($eventDispatcher, $formFactory,$userManager, $tokenStorage);
      $this->eventDispatcher = $eventDispatcher;
      $this->formFactory = $formFactory;
      $this->userManager = $userManager;
      $this->tokenStorage = $tokenStorage;
    }

  /** 
   * Registrate a new User
   * @FOSRest\post("register")
   */
  public function registerAction(Request $request) {
    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    $formFactory = $this->formFactory;//$this->get('fos_user.registration.form.factory');
    /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
    $userManager = $this->get('fos_user.user_manager');
    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');

    $user = $userManager->createUser();
    $user->setEnabled(true);

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

    if (null !== $event->getResponse()) {
        return $event->getResponse();
    }

    $form = $formFactory->createForm([
        'csrf_protection'    => false
    ]);

    $form->setData($user);
    $form->submit($request->request->all());

    if (!$form->isValid()) {

        $event = new FormEvent($form, $request);

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

        if (null !== $response = $event->getResponse()) {
            return $response;
        }

        return $form;
    }

    $event = new FormEvent($form, $request);
    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

    if ($event->getResponse()) {
      return $event->getResponse();
    }

    $userManager->updateUser($user);


    $response = new JsonResponse(
      [
          'msg' => $this->get('translator')->trans('registration.flash.user_created', [], 'FOSUserBundle'),
          'token' => 'abc-123' // <<<---- this bit
      ],
      JsonResponse::HTTP_CREATED /*,
      [
          'Location' => $this->generateUrl(
              'get_profile',
              [ 'user' => $user->getId() ],
              UrlGeneratorInterface::ABSOLUTE_URL
          )
      ]*/
  );

    /*
    $response = new JsonResponse(
        [
          'msg' => $this->get('translator')->trans('registration.flash.user_created', [], 'FOSUserBundle'),
          'token' => 'abc-123' // some way of creating the token
        ],
        JsonResponse::HTTP_CREATED,
        [
            'Location' => $this->generateUrl(
                'get_profile',
                [ 'user' => $user->getId() ],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        ]
    );

    $dispatcher->dispatch(
      FOSUserEvents::REGISTRATION_COMPLETED,
      new FilterUserResponseEvent($user, $request, $response)
    );

    return $response;*/

    return $response;
  }
}