<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Person;
use App\DataFixtures\UserFixtures;

class PersonFixtures extends Fixture implements DependentFixtureInterface
{
  public const PHYSICAL_1_REFERENCE = 'PHYSICAL_1';
  public const PHYSICAL_2_REFERENCE = 'PHYSICAL_2';
  public const PHYSICAL_3_REFERENCE = 'PHYSICAL_3';
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

    $json = file_get_contents($this->dataJsonDirectory . 'people.json');
    $jsonData = json_decode($json);

    foreach ($jsonData as $data) {
      $person = new Person($data);
      $person->setUserCreated($user);
      $person->setUserUpdated($user);

      $manager->persist($person);

      switch ($data->reference) {
        case self::PHYSICAL_1_REFERENCE: 
          $this->addReference(self::PHYSICAL_1_REFERENCE, $person);
          break;
        case self::PHYSICAL_2_REFERENCE: 
          $this->addReference(self::PHYSICAL_2_REFERENCE, $person);
          break;
        case self::PHYSICAL_3_REFERENCE: 
          $this->addReference(self::PHYSICAL_3_REFERENCE, $person);
          break;
        case self::LEGAL_1_REFERENCE:
          $this->addReference(self::LEGAL_1_REFERENCE, $person);
          break;
        case self::LEGAL_2_REFERENCE:
          $this->addReference(self::LEGAL_2_REFERENCE, $person);
          break;
        default:
          break;
      }
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
    );
  }
}