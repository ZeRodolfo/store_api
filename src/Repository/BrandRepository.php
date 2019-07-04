<?php 

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BrandRepository extends ServiceEntityRepository {
  protected $registry;
  protected $data = [];

  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Brand::class);

    $this->registry = $registry;
  }

  public function findAll($format = null) {
    $this->data = parent::findAll();

    return $this->format($format);
  }

  public function find($id, $lockMode = NULL, $lockVersion = NULL, $format = NULL) {
    $this->data = parent::find($id, $lockMode, $lockVersion);

    return $this->format($format);
  }

  public function save(Brand $brand) {
    $em = $this->registry->getManager();
    try {
      $em->persist($brand);
    } catch (Exception $ex) {
      return false;
    } finally {
      $em->flush();
    }

    $this->data = $brand;
    
    return true;
  }

  private function format($format = null) {
    switch ($format) {
      case 'json':
        return $this->toJSON();
      case null:
        return $this;
      default:
        return $this->data;
    }
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