<?php 

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Product;
use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\UserFixtures;

use \DateTime;


class ProductFixtures extends Fixture implements DependentFixtureInterface {
  public function load(ObjectManager $manager) {
    $products = [
      [
        'name' => 'Arroz',
        'description' => 'O arroz é uma planta da família das gramíneas que alimenta mais da metade da população humana do mundo. É a terceira maior cultura cerealífera do mundo, apenas ultrapassada pelas de milho e trigo. É rico em hidratos de carbono.',
        'categories' => [CategoryFixtures::AGRICULTURA_REFERENCE]
      ]
    ];

    for ($line = 0; $line < count($products); $line++) {
      $product = new Product();
      $product->setName($products[$line]['name']);
      $product->setDescription($products[$line]['description']);
      /*$product->setUserCreated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $product->setUserUpdated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $product->setCreatedAt(new DateTime('now'));
      $product->setUpdatedAt(new DateTime('now'));
*/
      foreach ($products[$line]['categories'] as $categoryReference) {
        $product->addCategory($this->getReference($categoryReference));
      }

      $manager->persist($product);
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
      CategoryFixtures::class,
    );
  }

}