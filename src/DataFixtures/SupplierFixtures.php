<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Supplier;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\PersonFixtures;

class SupplierFixtures extends Fixture implements DependentFixtureInterface
{
  protected $dataJsonDirectory;

  public function __construct($dataJsonDirectory) 
  {
    $this->dataJsonDirectory = $dataJsonDirectory;
  }

	public function load(ObjectManager $manager)
	{
    $user = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);

    $json = file_get_contents($this->dataJsonDirectory . 'supplier.json');
    $jsonData = json_decode($json);

    foreach ($jsonData as $data) {
      $person = $data->personReference;

      $supplier = new Supplier($data);
      $supplier->setUserCreated($user);
      $supplier->setUserUpdated($user);

      switch ($person) {
        case PersonFixtures::LEGAL_1_REFERENCE: 
          $supplier->setPerson($this->getReference(PersonFixtures::LEGAL_1_REFERENCE));
          break;
        case PersonFixtures::LEGAL_2_REFERENCE: 
          $supplier->setPerson($this->getReference(PersonFixtures::LEGAL_2_REFERENCE));
          break;
        default:
          break;
      }
      
      $manager->persist($supplier);
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
      PersonFixtures::class
    );
  }
}