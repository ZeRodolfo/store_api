<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;

use \DateTime;

class CategoryFixtures extends Fixture {
  public function load(ObjectManager $manager) {

    $categories = [
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => '',
      '' => ''
    ];

    foreach ($categories as $name => $description) {
      $category = new Category();
      $category->setName($name);
      $category->setDescription($description);
      $category->setActive(true);
      $category->setParent(NULL);
      //$category->setUserCreated();
      //$category->setUserUpdated();
      $category->setCreatedAt(new DateTime('now'));
      $category->setUpdatedAt(new DateTime('now'));
    }

    $manager->flush();
  }
}