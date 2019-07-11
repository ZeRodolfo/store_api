<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Address;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\SupplierFixtures;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
  public const LEGAL_1_REFERENCE = 'LEGAL_1';
  public const LEGAL_2_REFERENCE = 'LEGAL_2';

  protected $dataJsonDirectory;

  public function __construct($dataJsonDirectory) 
  {
    $this->dataJsonDirectory = $dataJsonDirectory;
  }

	public function load(ObjectManager $manager)
	{
    $user = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);

    $json = file_get_contents($this->dataJsonDirectory . 'address.json');
    $jsonData = json_decode($json);

    foreach ($jsonData as $data) {
      $supplier = $data->supplierReference;

      $address = new Address($data);
      $address->setUserCreated($user);
      $address->setUserUpdated($user);

      switch ($supplier) {
        case self::LEGAL_1_REFERENCE: 
          $address->setSupplier($this->getReference(SupplierFixtures::LEGAL_1_REFERENCE));
          break;
        case self::LEGAL_2_REFERENCE: 
          $address->setSupplier($this->getReference(SupplierFixtures::LEGAL_2_REFERENCE));
          break;
        default:
          break;
      }

      $manager->persist($address);
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
      SupplierFixtures::class
    );
  }
}