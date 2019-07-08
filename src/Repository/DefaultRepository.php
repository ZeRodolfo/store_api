<?php 

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


abstract class DefaultRepository extends ServiceEntityRepository {
  protected $registry;
  protected $data = [];
  protected $errors;

  public function __construct(RegistryInterface $registry, $object) {
    parent::__construct($registry, $object);

    $this->registry = $registry;
  }

  public function clear() {
    $this->data = [];
    $this->errors = null;
  }

  public function findAll($format = null) {
    $this->data = parent::findAll();

    return $this->format($format);
  }

  public function find($id, $lockMode = NULL, $lockVersion = NULL, $format = NULL) {
    $this->data = parent::find($id, $lockMode, $lockVersion);

    return $this->format($format);
  }

  public function getErrors() {
    return $this->errors;
  }
  
  private function format($format = null) {
    switch ($format) {
      case 'json':
        return $this->toJSON();
      case null:
        return $this->data;
      default:
        return $this;
    }
  }
}