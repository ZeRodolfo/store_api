<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Person;
use App\DataFixtures\UserFixtures;

class PersonFixtures extends Fixture implements DependentFixtureInterface
{
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
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
    );
  }
}