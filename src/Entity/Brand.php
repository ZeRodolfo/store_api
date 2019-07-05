<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="brand")
 */
class Brand {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=200)
   */
  private $name;

  /**
   * @ORM\Column(type="text")
   */
  private $description;

  /**
   * @ORM\Column(type="boolean")
   */
  private $active;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="brandsCreated")
   * @ORM\JoinColumn(nullable=false)
   */
  private $userCreated;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="brandsUpdated")
   * @ORM\JoinColumn(nullable=false)
   */
  private $userUpdated;

  /**
   * @ORM\Column(type="datetime")
   */
  private $createdAt;

  /**
   * @ORM\Column(type="datetime")
   */
  private $updatedAt;

  /** 
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /** 
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /** 
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }

  /** 
   * @param mixed $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /** 
   * @return mixed
   */
  public function getDescription() {
    return $this->description;
  }

  /** 
   * @param mixed $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  public function getActive(): ?bool
  {
      return $this->active;
  }

  public function setActive(bool $active): self
  {
      $this->active = $active;

      return $this;
  }

  public function getUserCreated(): ?User
  {
      return $this->userCreated;
  }

  public function setUserCreated(?User $userCreated): self
  {
      $this->userCreated = $userCreated;

      return $this;
  }

  public function getUserUpdated(): ?User
  {
      return $this->userUpdated;
  }

  public function setUserUpdated(?User $userUpdated): self
  {
      $this->userUpdated = $userUpdated;

      return $this;
  }

  public function getCreatedAt(): ?\DateTimeInterface
  {
      return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeInterface $createdAt): self
  {
      $this->createdAt = $createdAt;

      return $this;
  }

  public function getUpdatedAt(): ?\DateTimeInterface
  {
      return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeInterface $updatedAt): self
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }

  public function __construct($data) {
    $this->name = isset($data->name) ? $data->name : "";
    $this->description = isset($data->description) ? $data->description : "";
    $this->active = isset($data->active) ? $data->active : true;
    $this->createdAt = isset($data->createdAt) ? $data->createdAt : new DateTime('now');
    $this->updatedAt = isset($data->updatedAt) ? $data->updatedAt : new DateTime('now');
  }

  public function load($data) {
    $this->name = isset($data->name) ? $data->name : $this->name;
    $this->description = isset($data->description) ? $data->description : $this->description;
    $this->active = isset($data->active) ? $data->active : $this->active;
    $this->createdAt = isset($data->createdAt) ? $data->createdAt : $this->createdAt;
    $this->updatedAt = isset($data->updatedAt) ? $data->updatedAt : $this->updatedAt;
  }

  public function toJSON() {
    return [
      "id"    => $this->id,
      "name"  => $this->name,
      "description" => $this->description,
      "active" => $this->active,
      "userCreated" => $this->userCreated->toJSON(),
      "userUpdated" => $this->userUpdated->toJSON(),
      "createdAt"   => $this->createdAt->format('d-m-Y'),
      "updatedAt"   => $this->updatedAt->format('d-m-Y')
    ];
  }
}