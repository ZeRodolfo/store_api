<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserFixtures extends Fixture {

  public const ADMIN_USER_REFERENCE = 'ROLE_ADMIN';

  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager) {
    $userAdmin = new User();
    $password = $this->encoder->encodePassword($userAdmin, '123mudar');

    $userAdmin->setUsername('admin');
    $userAdmin->setEmail('jrodolfo@example.com');
    $userAdmin->setPassword($password);
    $userAdmin->setEnabled(true);
    $userAdmin->setRoles(['ROLE_ADMIN']);

    $manager->persist($userAdmin);
    $manager->flush();


    // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
    $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
  }
}