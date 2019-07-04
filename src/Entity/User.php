<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
  /** 
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="userCreated")
   */
  private $brandsCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="userUpdated")
   */
  private $brandsUpdated;

  public function __construct() {
    parent::__construct();
    $this->brandsCreated = new ArrayCollection();
    $this->brandsUpdated = new ArrayCollection();
  }

  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_ADMIN';

    return array_unique($roles);
  }

  /**
   * @return Collection|Brand[]
   */
  public function getBrandsCreated(): Collection
  {
      return $this->brandsCreated;
  }

  public function addBrandsCreated(Brand $brandsCreated): self
  {
      if (!$this->brandsCreated->contains($brandsCreated)) {
          $this->brandsCreated[] = $brandsCreated;
          $brandsCreated->setUserCreated($this);
      }

      return $this;
  }

  public function removeBrandsCreated(Brand $brandsCreated): self
  {
      if ($this->brandsCreated->contains($brandsCreated)) {
          $this->brandsCreated->removeElement($brandsCreated);
          // set the owning side to null (unless already changed)
          if ($brandsCreated->getUserCreated() === $this) {
              $brandsCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Brand[]
   */
  public function getBrandsUpdated(): Collection
  {
      return $this->brandsUpdated;
  }

  public function addBrandsUpdated(Brand $brandsUpdated): self
  {
      if (!$this->brandsUpdated->contains($brandsUpdated)) {
          $this->brandsUpdated[] = $brandsUpdated;
          $brandsUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeBrandsUpdated(Brand $brandsUpdated): self
  {
      if ($this->brandsUpdated->contains($brandsUpdated)) {
          $this->brandsUpdated->removeElement($brandsUpdated);
          // set the owning side to null (unless already changed)
          if ($brandsUpdated->getUserUpdated() === $this) {
              $brandsUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }

  public function toJSON() {
    return [
      "id"    => $this->id,
      "username"  => $this->username,
    ];
  }
}