<?php 

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BrandRepository extends DefaultRepository {
  protected $registry;
  protected $data = [];
  protected $errors;

  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Brand::class);

    $this->registry = $registry;
  }

  public function save(Brand $brand) {
    $this->clear();

    $em = $this->registry->getManager();

    try {
      $em->persist($brand);
    } catch (Exception $ex) {
      $this->errors = $ex->getMessage();

      return false;
    } finally {
      $em->flush();
    }

    $this->data = $brand;

    return true;
  }

  public function delete(Brand $brand) {
    $this->clear();

    $em = $this->registry->getManager();

    try {
      $em->remove($brand);
    } catch (Exception $ex) {
      $this->errors = $ex->getMessage();

      return false;
    } finally {
      $em->flush();
    }

    $this->data = [];

    return true;
  }

  public function toJSON() {
    if ($this->data instanceof Brand) {
      return $this->data->toJSON();
    } else {
      $collections = [];

      foreach ($this->data as $data) {
        $collections[] = $data->toJSON();
      }

      return $collections;
    }
  }
}